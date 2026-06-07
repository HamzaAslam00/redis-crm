<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreInvestmentExpenseRequest;
use App\Http\Requests\Backend\StoreInvestmentRequest;
use App\Http\Requests\Backend\UpdateInvestmentRequest;
use App\Models\Investment;
use App\Models\InvestmentExpense;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvestmentController extends Controller
{
    public function index(): View
    {
        return view('backend.investments.index');
    }

    public function create(): View
    {
        return view('backend.investments.create', [
            'statuses' => Investment::$statuses,
            'currencies' => Investment::$currencies,
        ]);
    }

    public function store(StoreInvestmentRequest $request): RedirectResponse
    {
        $investment = Investment::create($request->validated());

        return redirect()->route('admin.investments.show', $investment)
            ->with('success', "Investment for {$investment->person_name} created.");
    }

    public function show(Investment $investment): View
    {
        $investment->load('expenses');

        return view('backend.investments.show', compact('investment'));
    }

    public function edit(Investment $investment): View
    {
        return view('backend.investments.edit', [
            'investment' => $investment,
            'statuses' => Investment::$statuses,
            'currencies' => Investment::$currencies,
        ]);
    }

    public function update(UpdateInvestmentRequest $request, Investment $investment): RedirectResponse
    {
        $investment->update($request->validated());

        return redirect()->route('admin.investments.show', $investment)
            ->with('success', 'Investment updated successfully.');
    }

    public function destroy(Investment $investment): RedirectResponse
    {
        $investment->delete();

        return redirect()->route('admin.investments.index')
            ->with('success', 'Investment deleted.');
    }

    public function storeExpense(StoreInvestmentExpenseRequest $request, Investment $investment): RedirectResponse
    {
        $investment->expenses()->create($request->validated());

        return back()->with('success', 'Expense added.');
    }

    public function destroyExpense(Investment $investment, InvestmentExpense $expense): RedirectResponse
    {
        $expense->delete();

        return back()->with('success', 'Expense deleted.');
    }
}
