<?php

use App\Http\Controllers\Backend\BudgetController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HostingClientController;
use App\Http\Controllers\Backend\InvestmentController;
use App\Http\Controllers\Backend\ProjectController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\UserController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Projects
    Route::middleware('can:project.view')->group(function () {
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
        Route::post('projects/{project}/messages', function (Request $request, Project $project) {
            $request->validate(['message' => ['required', 'string'], 'is_client' => ['boolean']]);
            $project->messages()->create([
                'user_id' => auth()->id(),
                'message' => $request->message,
                'is_client' => $request->boolean('is_client'),
            ]);

            return back()->with('success', 'Note added.');
        })->name('projects.messages.store');
    });

    // Investments
    Route::middleware('can:investment.view')->group(function () {
        Route::resource('investments', InvestmentController::class)->except(['show']);
        Route::get('investments/{investment}', [InvestmentController::class, 'show'])->name('investments.show');
        Route::post('investments/{investment}/expenses', [InvestmentController::class, 'storeExpense'])->name('investments.expenses.store');
        Route::delete('investments/{investment}/expenses/{expense}', [InvestmentController::class, 'destroyExpense'])->name('investments.expenses.destroy');
    });

    // Budget
    Route::middleware('can:budget.view')->prefix('budget')->name('budget.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::get('expenses/create', [BudgetController::class, 'createExpense'])->name('expenses.create');
        Route::post('expenses', [BudgetController::class, 'storeExpense'])->name('expenses.store');
        Route::get('expenses/{expense}/edit', [BudgetController::class, 'editExpense'])->name('expenses.edit');
        Route::put('expenses/{expense}', [BudgetController::class, 'updateExpense'])->name('expenses.update');
        Route::delete('expenses/{expense}', [BudgetController::class, 'destroyExpense'])->name('expenses.destroy');
        Route::get('incomes/create', [BudgetController::class, 'createIncome'])->name('incomes.create');
        Route::post('incomes', [BudgetController::class, 'storeIncome'])->name('incomes.store');
        Route::get('incomes/{income}/edit', [BudgetController::class, 'editIncome'])->name('incomes.edit');
        Route::put('incomes/{income}', [BudgetController::class, 'updateIncome'])->name('incomes.update');
        Route::delete('incomes/{income}', [BudgetController::class, 'destroyIncome'])->name('incomes.destroy');
    });

    // Hosting Clients
    Route::middleware('can:hosting.view')->resource('hosting', HostingClientController::class)->except(['show'])
        ->parameters(['hosting' => 'hosting']);

    // Placeholder routes (Phase 4+)
    Route::get('api-keys', fn () => view('backend.placeholder', ['page' => 'API Keys Vault']))->name('api-keys.index');
    Route::get('credentials', fn () => view('backend.placeholder', ['page' => 'Credentials Vault']))->name('credentials.index');
    Route::get('notes', fn () => view('backend.placeholder', ['page' => 'Personal Notes']))->name('notes.index');
    Route::get('contacts', fn () => view('backend.placeholder', ['page' => 'Contact Messages']))->name('contacts.index');
    Route::get('proposals', fn () => view('backend.placeholder', ['page' => 'Proposals']))->name('proposals.index');
    Route::get('portfolio', fn () => view('backend.placeholder', ['page' => 'Portfolio']))->name('portfolio.index');
    Route::get('blog', fn () => view('backend.placeholder', ['page' => 'Blog Posts']))->name('blog.index');
    Route::get('activity', fn () => view('backend.placeholder', ['page' => 'Activity Logs']))->name('activity.index');

    // Users & Roles
    Route::middleware('can:user.view')->resource('users', UserController::class)->except(['show']);
    Route::middleware('can:role.view')->resource('roles', RoleController::class)->except(['show']);

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

});
