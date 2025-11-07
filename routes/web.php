<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Livewire\FinanceDetailLivewire; // Keep this if FinanceDetailLivewire is still used

// =======================
// HALAMAN UTAMA
// =======================
Route::get('/app/finance/{id}', FinanceDetailLivewire::class)->middleware('check.auth');
Route::get('/', fn () => redirect('/app/home'));

// =======================
// AUTH
// =======================
Route::group(['prefix' => 'auth'], function () {

    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

});

// =======================
// APP PROTECTED AREA
// =======================
Route::group(['prefix' => 'app', 'middleware' => 'check.auth'], function () {

    Route::get('/home', [HomeController::class, 'home'])->name('app.home');
    Route::get('/detail/{id}', \App\Livewire\FinanceDetailLivewire::class)->name('finance.detail');
    Route::get('/statistics', \App\Livewire\StatisticLivewire::class)->name('app.statistics');

});
