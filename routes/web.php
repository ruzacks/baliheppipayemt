<?php

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


