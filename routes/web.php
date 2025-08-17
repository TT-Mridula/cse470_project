<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\MainPagesController;
use App\Http\Controllers\ServicePagesController;
use App\Http\Controllers\PortfolioPagesController;
use App\Http\Controllers\AboutPagesController;
use App\Http\Controllers\ContactFormController;

/* ---------- Public site ---------- */
Route::get('/', [PagesController::class, 'index'])->name('home');

/* ---------- Admin: dashboard & main ---------- */
Route::get('/admin/dashboard', [PagesController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/admin/main',  [MainPagesController::class, 'index'])->name('admin.main');
Route::put('/admin/main',  [MainPagesController::class, 'update'])->name('admin.main.update');

/* ---------- Admin: Services ---------- */
Route::get('/admin/services',                [PagesController::class, 'services'])->name('admin.services');
Route::get('/admin/services/create',         [ServicePagesController::class, 'create'])->name('admin.services.create');
Route::post('/admin/services/create',        [ServicePagesController::class, 'store'])->name('admin.services.store');
Route::get('/admin/services/list',           [ServicePagesController::class, 'list'])->name('admin.services.list');
Route::get('/admin/services/edit/{id}',      [ServicePagesController::class, 'edit'])->name('admin.services.edit');
Route::put('/admin/services/update/{id}',    [ServicePagesController::class, 'update'])->name('admin.services.update');
Route::delete('/admin/services/destroy/{id}',[ServicePagesController::class, 'destroy'])->name('admin.services.destroy');

/* ---------- Admin: Portfolios ---------- */
Route::get('/admin/portfolios/create',         [PortfolioPagesController::class, 'create'])->name('admin.portfolios.create');
Route::put('/admin/portfolios/create',        [PortfolioPagesController::class, 'store'])->name('admin.portfolios.store');
Route::get('/admin/portfolios/list',           [PortfolioPagesController::class, 'list'])->name('admin.portfolios.list');
Route::get('/admin/portfolios/edit/{id}',      [PortfolioPagesController::class, 'edit'])->name('admin.portfolios.edit');
Route::put('/admin/portfolios/update/{id}',    [PortfolioPagesController::class, 'update'])->name('admin.portfolios.update');
Route::delete('/admin/portfolios/destroy/{id}',[PortfolioPagesController::class, 'destroy'])->name('admin.portfolios.destroy');

/* ---------- Admin: Abouts ---------- */
// Route::get('/admin/abouts/create',         [AboutPagesController::class, 'create'])->name('admin.abouts.create');
// Route::post('/admin/abouts/create',        [AboutPagesController::class, 'store'])->name('admin.abouts.store');
// Route::get('/admin/abouts/list',           [AboutPagesController::class, 'list'])->name('admin.abouts.list');
// Route::get('/admin/abouts/edit/{id}',      [AboutPagesController::class, 'edit'])->name('admin.abouts.edit');
// Route::put('/admin/abouts/update/{id}',    [AboutPagesController::class, 'update'])->name('admin.abouts.update');
// Route::delete('/admin/abouts/destroy/{id}',[AboutPagesController::class, 'destroy'])->name('admin.abouts.destroy');

// /* ---------- Simple admin pages (if you still use these menus) ---------- */
Route::get('/admin/portfolio', [PagesController::class, 'portfolio'])->name('admin.portfolio');
Route::get('/admin/about',     [PagesController::class, 'about'])->name('admin.about');
Route::get('/admin/contact',   [PagesController::class, 'contact'])->name('admin.contact');

/* ---------- Public: contact form submit ---------- */
// Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

/* ---------- Auth scaffolding ---------- */
Auth::routes();

/* Avoid duplicate route name "home" if the line below exists
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
