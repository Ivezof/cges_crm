<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\WorkersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::middleware('role:administrator')->group(function () {
        Route::get('/', function () {
            return view('index');
        })->name('index');

        Route::get('/dashboard', function () {
            return view('index');
        })->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'load'])->name('profile');
        Route::get('/workers', [WorkersController::class, 'getWorkers'])->name('workers');
    });



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

    Route::get('/api/table/workers', [ApiController::class, 'getWorkers']);
    Route::post('/api/workers/delete', [ApiController::class, 'deleteWorker']);
    Route::post('/api/workers/update', [ApiController::class, 'workerUpdate']);
    Route::get('/api/workers/get', [ApiController::class, 'getWorker']);
    Route::get('/api/workers/all', [ApiController::class, 'getAllWorkers']);



    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('/api/orders', [ApiController::class, 'getAllOrders'])->name('allOrders');
    Route::get('/api/orders/get/{id}', [ApiController::class, 'getOrder'])->name('getOrder');
    Route::post('/api/orders/update', [ApiController::class, 'orderUpdate']);

});

Route::get('/order/{verified?}',  function () {
    return view('clients.form');
})->name('client.form');

Route::post('/order', [ClientsController::class, 'addOrder'])->name('addOrder');

Route::get('/email/verify/{code}', [ClientsController::class, 'verify'])->name('verify');

require __DIR__.'/auth.php';
