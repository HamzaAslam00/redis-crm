<?php

namespace App\Livewire\Backend;

use App\Models\BudgetExpense;
use App\Models\BudgetIncome;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetTable extends Component
{
    use WithPagination;

    #[Url]
    public string $tab = 'expenses';

    #[Url]
    public string $monthFilter = '';

    #[Url]
    public string $typeFilter = '';

    public int $perPage = 15;

    public function updatedTab(): void
    {
        $this->resetPage();
        $this->typeFilter = '';
    }

    public function updatedMonthFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    #[On('delete')]
    public function delete(int $id, ?string $type = null): void
    {
        if ($type === 'income') {
            BudgetIncome::findOrFail($id)->delete();
            $this->dispatch('toast', type: 'success', message: 'Income deleted.');
        } else {
            BudgetExpense::findOrFail($id)->delete();
            $this->dispatch('toast', type: 'success', message: 'Expense deleted.');
        }
    }

    /** @return LengthAwarePaginator<BudgetExpense> */
    private function getExpenses(): LengthAwarePaginator
    {
        return BudgetExpense::query()
            ->when($this->monthFilter, fn ($q) => $q->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$this->monthFilter]))
            ->when($this->typeFilter, fn ($q) => $q->where('type', $this->typeFilter))
            ->orderBy('date', 'desc')
            ->paginate($this->perPage);
    }

    /** @return LengthAwarePaginator<BudgetIncome> */
    private function getIncomes(): LengthAwarePaginator
    {
        return BudgetIncome::query()
            ->when($this->monthFilter, fn ($q) => $q->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$this->monthFilter]))
            ->orderBy('date', 'desc')
            ->paginate($this->perPage);
    }

    private function getSummary(): array
    {
        $monthClause = $this->monthFilter
            ? ['whereRaw' => ['DATE_FORMAT(date, "%Y-%m") = ?', [$this->monthFilter]]]
            : null;

        $expenseQ = BudgetExpense::query();
        $incomeQ = BudgetIncome::query();

        if ($monthClause) {
            $expenseQ->whereRaw($monthClause['whereRaw'][0], $monthClause['whereRaw'][1]);
            $incomeQ->whereRaw($monthClause['whereRaw'][0], $monthClause['whereRaw'][1]);
        }

        $totalExpense = (float) $expenseQ->sum('amount');
        $totalIncome = (float) $incomeQ->sum('amount');

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net' => $totalIncome - $totalExpense,
        ];
    }

    public function render(): View
    {
        return view('livewire.backend.budget-table', [
            'expenses' => $this->tab === 'expenses' ? $this->getExpenses() : null,
            'incomes' => $this->tab === 'incomes' ? $this->getIncomes() : null,
            'summary' => $this->getSummary(),
            'types' => BudgetExpense::$types,
        ]);
    }
}
