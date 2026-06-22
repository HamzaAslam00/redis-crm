<x-layouts.backend title="Edit Proposal — {{ $proposal->proposal_number }}">

    <x-backend.page-header title="Edit Proposal" subtitle="{{ $proposal->proposal_number }} — {{ $proposal->client_name }}">
        <a href="{{ route('admin.proposals.show', $proposal) }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Back
        </a>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="[
        'Proposals'                  => route('admin.proposals.index'),
        $proposal->proposal_number   => route('admin.proposals.show', $proposal),
        'Edit'                       => null,
    ]" />

    @include('backend.proposals._form', [
        'action'       => route('admin.proposals.update', $proposal),
        'method'       => 'PUT',
        'proposal'     => $proposal,
        'defaultTerms' => $proposal->terms_conditions ?? '',
    ])

</x-layouts.backend>
