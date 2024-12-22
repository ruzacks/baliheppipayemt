<?php

use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page.homepage');
});

Route::get('/mybill', function () {
    return view('page.payment-app');
});

Route::get('/payment', function () {
    return view('page.payment');
});

Route::get('/success', function () {
    return view('page.success');
});

Route::get('/failed', function () {
    return view('page.failed');
});

Route::post('/payment-request', [MidtransController::class, 'create'])->name('payment.request');

Route::post('/token-request', [MidtransController::class, 'getSnapToken'])->name('token.request');

Route::get('/status-request/{trans_id}', [MidtransController::class, 'getStatus'])->name('status.request');