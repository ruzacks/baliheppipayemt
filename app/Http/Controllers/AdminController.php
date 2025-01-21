<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Transactions for the current month
        $transactions = Invoice::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear);

        // Count of transactions
        $countOfTransaction = $transactions->count();

        // Sum of transaction amounts
        $sumOfTransaction = $transactions->sum('amount');

        // Sum of profits for the current month
        $sumOfProfit = $transactions->get()->reduce(function ($carry, $invoice) {
            if ($invoice->netto > 0) {
                return $carry + $invoice->profit();
            }
            return $carry;
        }, 0);
        
        // Retrieve filters from the request
        $status = $request->input('status');
        $invoiceNo = $request->input('invoice_no');

        // Build the query
        $query = Invoice::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($invoiceNo) {
            $query->where('invoice_code', 'LIKE', "%{$invoiceNo}%");
        }

        $invoices = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Keep filter values in pagination links
        $invoices->appends($request->all());

        return view('admin.index', compact('invoices', 'status', 'invoiceNo', 'countOfTransaction', 'sumOfTransaction', 'sumOfProfit'));
    }
}
