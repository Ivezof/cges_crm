<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'load'])->name('profile');

    Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
});

Route::middleware('auth')->group(function () {
    Route::get('/api/getStats', [StatsController::class, 'getStats']);
    Route::get('/api/getOrders', [StatsController::class, 'getOrders']);
});

Route::get('/order/{verified?}',  function () {
    return view('clients.form');
})->name('client.form');

Route::post('/order', [ClientsController::class, 'addOrder'])->name('addOrder');

Route::get('/email/verify/{code}', [ClientsController::class, 'verify'])->name('verify');

require __DIR__.'/auth.php';
