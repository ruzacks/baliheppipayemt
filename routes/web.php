<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IpaymuController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::post('api/get-invoice-detail',[InvoiceController::class, 'getDetail']);
Route::post('api/request-qr-payment',[IpaymuController::class, 'initiateQRPayment']);
Route::get('api/check-payment',[IpaymuController::class, 'checkPayment']);


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

Route::get('/link-bayar-success', function () {
    return view('page.linkbayar-success');
});

Route::get('/failed', function () {
    return view('page.failed');
});


Route::get('get-last-inv', [InvoiceController::class, 'getLastNumber'])->name('get-last-inv');
Route::post('invoices-store', [InvoiceController::class, 'store'])->name('invoices.store');


Route::post('/payment-request', [MidtransController::class, 'create'])->name('payment.request');

Route::post('/token-request', [MidtransController::class, 'getSnapToken'])->name('token.request');

Route::get('/status-request/{trans_id}', [MidtransController::class, 'getStatus'])->name('status.request');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('linkbayar', function () {
    return view('page.linkbayar');
});

Route::middleware('auth')->group(function () {
    Route::get('admin-panel', [AdminController::class, 'index'])->name('admin-panel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('initiate', [IpaymuController::class, 'initiate']);

require __DIR__.'/auth.php';
