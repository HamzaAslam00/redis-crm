<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BudgetExpense;
use App\Models\BudgetIncome;
use App\Models\HostingClient;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeProjects = Project::whereNotIn('status', ['completed', 'cancelled'])->count();

        $monthIncome = BudgetIncome::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $monthExpense = BudgetExpense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $runningBalance = (float) BudgetIncome::sum('amount') - (float) BudgetExpense::sum('amount');

        $renewalsDue = HostingClient::where('is_active', true)->get()
            ->filter(fn ($c) => $c->days_until_renewal <= 30)
            ->count();

        $projectsDueThisWeek = Project::whereNotIn('status', ['completed', 'cancelled'])
            ->whereNotNull('deadline')
            ->whereBetween('deadline', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->orderBy('deadline')
            ->limit(5)
            ->get();

        $renewalAlerts = HostingClient::where('is_active', true)->get()
            ->filter(fn ($c) => $c->days_until_renewal <= 30)
            ->sortBy('days_until_renewal')
            ->take(5);

        return view('backend.dashboard', compact(
            'activeProjects',
            'monthIncome',
            'monthExpense',
            'runningBalance',
            'renewalsDue',
            'projectsDueThisWeek',
            'renewalAlerts',
        ));
    }
}
