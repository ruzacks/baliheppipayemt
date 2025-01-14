<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiServiceController;
use App\Http\Controllers\DokuController;
use App\Http\Controllers\FeeSettingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IpaymuController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\DisableCors;
use App\Models\ApiService;
use Illuminate\Support\Facades\Route;






Route::middleware(DisableCors::class)->group(function () {
    Route::post('api/get-invoice-detail', [InvoiceController::class, 'getDetail']);
    Route::post('api/request-qr-payment', [IpaymuController::class, 'initiateQRPayment']);
    Route::get('api/check-payment', [IpaymuController::class, 'checkPayment']);
    Route::get('api/get-trans-method', [FeeSettingController::class, 'getTransMethod']);

    Route::post('api/request-card-payment', [DokuController::class, 'initiateCardPayment']);
    Route::get('api/callback', [DokuController::class, 'callback'])->name('callback');
});

// Route::get('/', function () {
//     return view('page.homepage');
// });

Route::get('/mybill', function () {
    return view('page.payment-app');
});

Route::get('/payment', function () {
    return view('page.payment');
});

Route::get('/success', function () {
    return view('page.success');
})->name('success_page');

Route::get('/link-bayar-success', function () {
    return view('page.linkbayar-success');
});

Route::get('/link-bayar-failed', function () {
    return view('page.linkbayar-failed');
});

Route::get('/link-bayar-pending', function () {
    return view('page.linkbayar-pending');
});

Route::get('/failed', function () {
    return view('page.failed');
})->name('failed_page');


Route::get('get-last-inv', [InvoiceController::class, 'getLastNumber'])->name('get-last-inv');
Route::post('invoices-store', [InvoiceController::class, 'store'])->name('invoices.store');


Route::post('/payment-request', [MidtransController::class, 'create'])->name('payment.request');

Route::post('/token-request', [MidtransController::class, 'getSnapToken'])->name('token.request');

Route::get('/status-request/{trans_id}', [MidtransController::class, 'getStatus'])->name('status.request');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('linkbayar', function () {
    return view('page.linkbayar');
})->name('linkbayar');

Route::middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-panel');
    Route::get('admin-panel', [AdminController::class, 'index'])->name('admin-panel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('fee-settings', FeeSettingController::class);
    Route::resource('products', ProductController::class);
    Route::resource('api_services', ApiServiceController::class);


});

Route::get('product-list', [ProductController::class, 'productList'])->name('product-list');
Route::post('create-invoice', [InvoiceController::class, 'createInvoice'])->name('create-invoice');

Route::get('initiate', [IpaymuController::class, 'initiate']);

Route::get('doku-initiate', [DokuController::class, 'initiate']);
Route::get('doku-trans-status', [DokuController::class, 'getTransactionStatus'])->name('doku-callback');


require __DIR__.'/auth.php';
