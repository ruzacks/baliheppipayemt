<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $invoices = Invoice::paginate(10);



        return view('admin.index', compact('invoices'));
    }
}
