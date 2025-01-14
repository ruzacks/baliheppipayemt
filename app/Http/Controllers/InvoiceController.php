<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class InvoiceController extends Controller
{
    public function getLastNumber()
    {
        // Fetch the latest invoice from the database
        $lastInvoice = Invoice::orderBy('created_at', 'desc')->first();

        if ($lastInvoice) {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = $lastInvoice->invoice_code; // Assuming 'number' is the column name
            return response()->json(['lastInvoice' => $lastInvoiceNumber]);
        }

        // Default fallback if no invoices exist
        $defaultInvoiceNumber = 'INV-' . now()->format('Ym') . '0000';
        return response()->json(['lastInvoice' => $defaultInvoiceNumber]);
    }

    public function store(Request $request)
    {
        
        try {
             // Remove commas before validation
            $amount = str_replace(',', '', $request->amount);
            $request->merge(['amount' => $amount]); // Update the request with the cleaned amount

            // Validate the incoming data
            $request->validate([
                'number' => 'required|unique:invoices,invoice_code|max:255',
                'amount' => 'required|numeric|min:0',
            ]);

            // Create the new invoice
            Invoice::create([
                'invoice_code' => $request->number,
                'amount' => $request->amount,
            ]);
    
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Invoice created successfully!');
        } catch (\Exception $e) {
            // Catch any exception and redirect back with an error message
            return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function getDetail(Request $request)
    {
        // // Validate the request input
        // $request->validate([
        //     'inv_code' => 'required|string|exists:invoices,invoice_code'
        // ]);

        // Find the invoice by code
        $invoice = Invoice::where('invoice_code', $request->inv_code)->first();

        if ($invoice) {

            if($invoice->status == 'paid'){
                return response()->json([
                    'status' => 'expired'
                ]);
            }
            // Check if the invoice date is within the last 24 hours
            $timeDifference = now()->diffInHours($invoice->created_at);
            // dd(abs($timeDifference));
            if (abs($timeDifference) <= 24) {
                return response()->json([
                    'status' => 'success',
                    'amount' => $invoice->amount,
                    'date'   => $invoice->created_at
                ]);
            } else {
                return response()->json([
                    'status' => 'expired'
                ]);
            }
        }

        // If the invoice is not found (this shouldn't happen due to validation)
        return response()->json([
            'status' => 'error',
            'message' => 'Invoice not found'
        ], 404);
    }

    public function createInvoice(Request $request) 
{
    // Validate the incoming request
    $request->validate([
        'cart' => 'required|array',
        'cart.*.id' => 'required|integer',
        'cart.*.name' => 'required|string',
        'cart.*.price' => 'required|numeric',
        'cart.*.qty' => 'required|integer'
    ]);

    // Calculate total amount
    $totalAmount = collect($request->cart)->sum(function ($item) {
        return $item['price'] * $item['qty'];
    });

    // Generate a unique invoice code based on the last number
    $lastInvoice = Invoice::orderBy('created_at', 'desc')->first();
    $lastNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_code, -4)) : 0;
    $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    $invoiceCode = 'INV-' . now()->format('Ym') . $newNumber;

    // Create the invoice
    $invoice = Invoice::create([
        'invoice_code' => $invoiceCode,
        'amount' => $totalAmount,
        'status' => 'unpaid',
        'date' => now()->toDateString()
    ]);

    // Create invoice details
    foreach ($request->cart as $item) {
        InvoiceDetail::create([
            'invoice_id' => $invoice->id,
            'product_id' => $item['id'],
            'product_name' => $item['name'],
            'qty' => $item['qty'],
            'price' => $item['price']
        ]);
    }

    // Return response with invoice code
    return response()->json([
        'message' => 'Invoice created successfully.',
        'invoice_code' => $invoiceCode
    ], 201);
}

    
}
