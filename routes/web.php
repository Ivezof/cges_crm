<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PaymentsController;
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
    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
});

Route::middleware('auth')->group(function () {
    Route::get('/api/getStats', [ApiController::class, 'getStats']);
    Route::get('/api/getOrders', [ApiController::class, 'getOrders']);
    Route::get('/api/table/client', [ApiController::class, 'getClients']);
    Route::post('/api/client/delete', [ApiController::class, 'deleteClients']);
    Route::post('/api/client/update', [ApiController::class, 'clientUpdate']);
    Route::get('/api/client/get', [ApiController::class, 'getClient']);

    Route::get('/api/table/payments', [ApiController::class, 'getPayments']);
    Route::post('/api/payments/delete', [ApiController::class, 'deletePayments']);
    Route::post('/api/payments/update', [ApiController::class, 'paymentUpdate']);
    Route::get('/api/payments/get', [ApiController::class, 'getPayment']);

});

Route::get('/order/{verified?}',  function () {
    return view('clients.form');
})->name('client.form');

Route::post('/order', [ClientsController::class, 'addOrder'])->name('addOrder');

Route::get('/email/verify/{code}', [ClientsController::class, 'verify'])->name('verify');

require __DIR__.'/auth.php';
