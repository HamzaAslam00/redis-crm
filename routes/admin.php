<?php

use App\Http\Controllers\Backend\ActivityLogController;
use App\Http\Controllers\Backend\ApiKeyController;
use App\Http\Controllers\Backend\BudgetController;
use App\Http\Controllers\Backend\ContactMessageController;
use App\Http\Controllers\Backend\CredentialController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HostingClientController;
use App\Http\Controllers\Backend\InvestmentController;
use App\Http\Controllers\Backend\PersonalNoteController;
use App\Http\Controllers\Backend\ProjectController;
use App\Http\Controllers\Backend\ProposalController;
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

    // API Keys Vault
    Route::middleware('can:apikey.view')->group(function () {
        Route::resource('api-keys', ApiKeyController::class)->except(['show'])->parameters(['api-keys' => 'apiKey']);
        Route::post('api-keys/{apiKey}/reveal', [ApiKeyController::class, 'reveal'])->name('api-keys.reveal');
    });

    // Credentials Vault
    Route::middleware('can:credential.view')->group(function () {
        Route::resource('credentials', CredentialController::class)->except(['show']);
        Route::post('credentials/{credential}/reveal', [CredentialController::class, 'reveal'])->name('credentials.reveal');
    });

    // Personal Notes
    Route::middleware('can:note.view')->resource('notes', PersonalNoteController::class)->except(['show'])->parameters(['notes' => 'note']);

    // Activity Logs
    Route::middleware('can:activity.view')->get('activity', [ActivityLogController::class, 'index'])->name('activity.index');

    // Contact Messages
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactMessageController::class, 'index'])->name('index');
        Route::get('{contact}', [ContactMessageController::class, 'show'])->name('show');
        Route::patch('{contact}/status', [ContactMessageController::class, 'updateStatus'])->name('status');
        Route::patch('{contact}/notes', [ContactMessageController::class, 'updateNotes'])->name('notes');
        Route::post('{contact}/reply', [ContactMessageController::class, 'reply'])->name('reply');
        Route::delete('{contact}', [ContactMessageController::class, 'destroy'])->name('destroy');
    });

    // Proposals
    Route::prefix('proposals')->name('proposals.')->group(function (): void {
        Route::get('/', [ProposalController::class, 'index'])->name('index');
        Route::get('/create', [ProposalController::class, 'create'])->name('create');
        Route::post('/', [ProposalController::class, 'store'])->name('store');
        Route::get('/{proposal}', [ProposalController::class, 'show'])->name('show');
        Route::get('/{proposal}/edit', [ProposalController::class, 'edit'])->name('edit');
        Route::put('/{proposal}', [ProposalController::class, 'update'])->name('update');
        Route::delete('/{proposal}', [ProposalController::class, 'destroy'])->name('destroy');
        Route::get('/{proposal}/pdf', [ProposalController::class, 'pdf'])->name('pdf');
        Route::get('/{proposal}/preview', [ProposalController::class, 'preview'])->name('preview');
        Route::post('/{proposal}/duplicate', [ProposalController::class, 'duplicate'])->name('duplicate');
        Route::patch('/{proposal}/status', [ProposalController::class, 'updateStatus'])->name('status');
    });

    // Placeholder routes (Phase 7+)
    Route::get('portfolio', fn () => view('backend.placeholder', ['page' => 'Portfolio']))->name('portfolio.index');
    Route::get('blog', fn () => view('backend.placeholder', ['page' => 'Blog Posts']))->name('blog.index');

    // Users & Roles
    Route::middleware('can:user.view')->resource('users', UserController::class)->except(['show']);
    Route::post('users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
    Route::post('impersonate/stop', [UserController::class, 'stopImpersonating'])->name('impersonate.stop');
    Route::middleware('can:role.view')->resource('roles', RoleController::class)->except(['show']);

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::put('settings/recaptcha', [SettingsController::class, 'updateRecaptcha'])->name('settings.recaptcha');

});
