<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
   // return view('welcome');
//});

use App\Http\Controllers\PagesController;

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('/admin/dashboard', [PagesController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/main', [PagesController::class, 'main'])->name('admin.main');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
