<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBudgetExpenseRequest;
use App\Http\Requests\Backend\StoreBudgetIncomeRequest;
use App\Http\Requests\Backend\UpdateBudgetExpenseRequest;
use App\Http\Requests\Backend\UpdateBudgetIncomeRequest;
use App\Models\BudgetExpense;
use App\Models\BudgetIncome;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function index(): View
    {
        return view('backend.budget.index');
    }

    public function createExpense(): View
    {
        return view('backend.budget.create-expense', [
            'types' => BudgetExpense::$types,
            'currencies' => BudgetExpense::$currencies,
        ]);
    }

    public function storeExpense(StoreBudgetExpenseRequest $request): RedirectResponse
    {
        BudgetExpense::create($request->validated());

        return redirect()->route('admin.budget.index')
            ->with('success', 'Expense recorded.');
    }

    public function editExpense(BudgetExpense $expense): View
    {
        return view('backend.budget.edit-expense', [
            'expense' => $expense,
            'types' => BudgetExpense::$types,
            'currencies' => BudgetExpense::$currencies,
        ]);
    }

    public function updateExpense(UpdateBudgetExpenseRequest $request, BudgetExpense $expense): RedirectResponse
    {
        $expense->update($request->validated());

        return redirect()->route('admin.budget.index')
            ->with('success', 'Expense updated.');
    }

    public function destroyExpense(BudgetExpense $expense): RedirectResponse
    {
        $expense->delete();

        return back()->with('success', 'Expense deleted.');
    }

    public function createIncome(): View
    {
        return view('backend.budget.create-income', [
            'currencies' => BudgetIncome::$currencies,
        ]);
    }

    public function storeIncome(StoreBudgetIncomeRequest $request): RedirectResponse
    {
        BudgetIncome::create($request->validated());

        return redirect()->route('admin.budget.index')
            ->with('success', 'Income recorded.');
    }

    public function editIncome(BudgetIncome $income): View
    {
        return view('backend.budget.edit-income', [
            'income' => $income,
            'currencies' => BudgetIncome::$currencies,
        ]);
    }

    public function updateIncome(UpdateBudgetIncomeRequest $request, BudgetIncome $income): RedirectResponse
    {
        $income->update($request->validated());

        return redirect()->route('admin.budget.index')
            ->with('success', 'Income updated.');
    }

    public function destroyIncome(BudgetIncome $income): RedirectResponse
    {
        $income->delete();

        return back()->with('success', 'Income deleted.');
    }
}
