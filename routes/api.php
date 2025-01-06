<?php
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;


Route::get('/example', function () {
    return response()->json(['message' => 'Hello, world!']);
});