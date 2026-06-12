<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - KalaFabrics
|--------------------------------------------------------------------------
*/

/* ══════════════════════════════════════
   HALAMAN PUBLIK (semua bisa akses)
══════════════════════════════════════ */
Route::get('/',          fn() => view('pages.home'))->name('home');
Route::get('/catalog',   fn() => view('pages.catalog'))->name('catalog');
Route::get('/impact',    fn() => view('pages.impact'))->name('impact');
Route::get('/education', fn() => view('pages.education'))->name('education');
Route::get('/ranger',    fn() => view('pages.ranger'))->name('ranger');
Route::get('/contact',   fn() => view('pages.contact'))->name('contact');

/* ══════════════════════════════════════
   AUTH ROUTES
══════════════════════════════════════ */
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* ══════════════════════════════════════
   HALAMAN PENGGUNA (harus login)
══════════════════════════════════════ */
Route::middleware(['auth', 'role:pengguna,ranger'])->group(function () {
    Route::get('/cart',     fn() => view('pages.cart'))->name('cart');
    Route::get('/checkout', fn() => view('pages.checkout'))->name('checkout');
});

/* ══════════════════════════════════════
   HALAMAN ADMIN
══════════════════════════════════════ */
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
