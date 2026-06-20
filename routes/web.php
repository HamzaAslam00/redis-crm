<?php

use App\Http\Controllers\Frontend\ContactSubmitController;
use App\Http\Controllers\Frontend\FreeAuditController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactSubmitController::class, 'store'])->middleware('throttle:3,60')->name('contact.store');
Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/free-audit', [HomeController::class, 'freeAudit'])->name('free-audit');
Route::post('/free-audit/analyze', [FreeAuditController::class, 'analyze'])->middleware('throttle:5,60')->name('free-audit.analyze');
Route::get('/free-consultation', [HomeController::class, 'freeConsultation'])->name('free-consultation');

// Blog placeholder (Phase 7B)
Route::get('/blog', fn () => view('frontend.blog-placeholder'))->name('blog.index');
Route::get('/blog/{slug}', fn () => abort(404))->name('blog.show');

/*
|--------------------------------------------------------------------------
| Auth & Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
