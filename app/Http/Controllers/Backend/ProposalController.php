<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreProposalRequest;
use App\Http\Requests\Backend\UpdateProposalRequest;
use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProposalController extends Controller
{
    public function index(): View
    {
        return view('backend.proposals.index');
    }

    public function create(): View
    {
        $defaultTerms = setting('proposal_default_terms', '');

        return view('backend.proposals.create', compact('defaultTerms'));
    }

    public function store(StoreProposalRequest $request): RedirectResponse
    {
        $proposal = Proposal::create($this->proposalData($request));

        $this->syncItems($proposal, $request->input('items', []));

        return redirect()
            ->route('admin.proposals.show', $proposal)
            ->with('success', "Proposal {$proposal->proposal_number} created.");
    }

    public function show(Proposal $proposal): View
    {
        $proposal->load('items', 'creator');

        return view('backend.proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal): View
    {
        $proposal->load('items');

        return view('backend.proposals.edit', compact('proposal'));
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal): RedirectResponse
    {
        $proposal->update($this->proposalData($request));

        $this->syncItems($proposal, $request->input('items', []));

        return redirect()
            ->route('admin.proposals.edit', $proposal)
            ->with('success', 'Proposal updated.');
    }

    public function destroy(Proposal $proposal): RedirectResponse
    {
        $proposal->delete();

        return redirect()
            ->route('admin.proposals.index')
            ->with('success', 'Proposal deleted.');
    }

    public function pdf(Proposal $proposal): Response
    {
        $proposal->load('items', 'creator');

        $pdf = $this->buildPdf($proposal);

        return $pdf->download("proposal-{$proposal->proposal_number}.pdf");
    }

    public function preview(Proposal $proposal): Response
    {
        $proposal->load('items', 'creator');

        $pdf = $this->buildPdf($proposal);

        return $pdf->stream("proposal-{$proposal->proposal_number}.pdf");
    }

    private function buildPdf(Proposal $proposal): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('pdf.proposal', compact('proposal'))
            ->setPaper('a4', 'portrait')
            ->setOption('dpi', 150)
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', false);
    }

    public function duplicate(Proposal $proposal): RedirectResponse
    {
        $proposal->load('items');

        $newProposal = $proposal->replicate(['proposal_number', 'status', 'sent_at', 'viewed_at', 'rejection_reason']);
        $newProposal->status = 'draft';
        $newProposal->created_by = auth()->id();
        $newProposal->save();

        foreach ($proposal->items as $item) {
            $newProposal->items()->create(
                $item->only(['title', 'description', 'delivery_days', 'unit_price', 'quantity', 'total', 'sort_order'])
            );
        }

        return redirect()
            ->route('admin.proposals.edit', $newProposal)
            ->with('success', "Duplicated as {$newProposal->proposal_number}.");
    }

    public function updateStatus(Request $request, Proposal $proposal): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:draft,sent,viewed,accepted,rejected,expired'],
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $proposal->update([
            'status' => $request->status,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Status updated.');
    }

    /** @return array<string, mixed> */
    private function proposalData(StoreProposalRequest|UpdateProposalRequest $request): array
    {
        $items = $request->input('items', []);

        $subtotal = collect($items)->sum(fn (array $item): float => (float) ($item['price'] ?? 0));

        $sectionsRaw = $request->input('sections_enabled');
        $sections = $sectionsRaw ? json_decode($sectionsRaw, true) : null;

        $milestonesRaw = $request->input('milestones');
        $milestones = $milestonesRaw ? json_decode($milestonesRaw, true) : null;

        return [
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'client_company' => $request->client_company,
            'platform' => $request->platform ?: null,
            'fiverr_username' => $request->fiverr_username,
            'project_title' => $request->project_title,
            'project_description' => $request->project_description,
            'currency' => $request->currency,
            'subtotal' => $subtotal,
            'discount_type' => 'fixed',
            'discount_amount' => 0,
            'total_amount' => $subtotal,
            'timeline' => $request->timeline,
            'revision_rounds' => $request->revision_rounds,
            'valid_until' => $request->valid_until,
            'terms_conditions' => $request->terms_conditions,
            'notes' => $request->notes,
            'sections_enabled' => $sections,
            'milestone_mode' => (bool) $request->input('milestone_mode', false),
            'milestones' => $milestones,
            'created_by' => auth()->id(),
        ];
    }

    /** @param array<int, array<string, mixed>> $items */
    private function syncItems(Proposal $proposal, array $items): void
    {
        $proposal->items()->delete();

        foreach ($items as $index => $item) {
            $price = (float) ($item['price'] ?? 0);

            $proposal->items()->create([
                'title' => $item['title'],
                'description' => $item['description'] ?? null,
                'delivery_days' => $item['delivery_days'] ?? null,
                'unit_price' => $price ?: null,
                'quantity' => 1,
                'total' => $price,
                'sort_order' => $index,
            ]);
        }
    }
}
