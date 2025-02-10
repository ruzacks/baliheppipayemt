<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\SalesPerson;
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

    public function deleteInvoiceAdmin(Invoice $invoice)
    {
        try {
            // Check if the invoice has related details
            if ($invoice->invoice_detail()->exists()) {
                // Delete all related invoice details
                $invoice->invoice_detail()->delete();
            }

            // Delete the invoice
            $invoice->delete();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            // Log the exception and handle errors
            \Log::error('Error deleting invoice: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to delete invoice. Please try again later.');
        }
    }


    public function getDetail(Request $request)
    {
        // // Validate the request input
        // $request->validate([
        //     'inv_code' => 'required|string|exists:invoices,invoice_code'
        // ]);

        // Find the invoice by code
        $invoice = Invoice::where('invoice_code','like', '%'.$request->inv_code.'%')->first();

        if ($invoice) {

            if($invoice->status == 'paid'){
                return response()->json([
                    'status' => 'expired'
                ]);
            }
            // Check if the invoice is expired based on expire_date
            if (now()->lessThanOrEqualTo($invoice->expire_date)) {
                return response()->json([
                    'status' => 'success',
                    'amount' => $invoice->amount,
                    'date'   => $invoice->created_at,
                    'expire_date' => $invoice->expire_date
                ]);
            } else {
                return response()->json([
                    'status' => 'expired',
                ]);
            }

        }

        // If the invoice is not found (this shouldn't happen due to validation)
        return response()->json([
            'status' => 'error',
            'message' => 'Invoice not found'
        ], 404);
    }

    public function createInvoiceAdmin()
    {
        return view('admin.create_invoice');
    }

    public function createInvoiceAdminManual()
    {
        return view('admin.create_invoice_manual');
    }

    public function storeInvoiceAdminManual(Request $request)
    {
        $lastInvoice = Invoice::orderBy('created_at', 'desc')->first();
        $lastNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_code, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $invoiceCode = 'INV-' . now()->format('Ym') . $newNumber;

        $invoice = Invoice::create([
            'invoice_code' => $invoiceCode,
            'amount' => $request->amount,
            'status' => 'manual',
            'date' => now()->toDateString(),
            'expire_date' => now(),
            'inv_type' => 'manual',
            'sales_person_id' => $request->salesId,
            'sales_commission' => $request->commission ?? null,
            'tax' => $request->tax,
            'fee' => $request->fee,
            'netto' => $request->netto,
            'payment_by' => $request->paymentBy,
        ]);

        // Return response with invoice code
        return response()->json([
            'status' => 'success',
            'message' => 'Invoice created successfully.',
            'invoice_code' => $invoiceCode
        ]);
    }

    public function createInvoice(Request $request) 
    {
        // Extract customer data from the request
        $custData = $request->only(['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'postcode']);

        // Create or update the customer and return the customer code in the response
        $customer = Customer::firstOrCreate(
            ['email' => $custData['email']],
            [
            'first_name' => $custData['first_name'],
            'last_name' => $custData['last_name'],
            'phone' => $custData['phone'],
            'address' => $custData['address'],
            'city' => $custData['city'],
            'state' => $custData['state'],
            'postcode' => $custData['postcode'],
            'customer_code' => 'CUST-' . uniqid(), // Generate a unique customer code
            ]
        );
        
        // Check if 'cart' or 'productsInCart' exists in the request
        if (!$request->has('cart') && !$request->has('productsInCart')) {
            return response()->json([
                'error' => 'Either cart or productsInCart must be provided.'
            ], 422);
        }

        // Determine which variable to validate
        $cartData = $request->has('cart') ? $request->input('cart') : $request->input('productsInCart');

        // Validate the chosen variable
        $request->validate([
            $request->has('cart') ? 'cart' : 'productsInCart' => 'required|array',
            $request->has('cart') ? 'cart.*.id' : 'productsInCart.*.id' => 'required|integer',
            $request->has('cart') ? 'cart.*.name' : 'productsInCart.*.name' => 'required|string',
            $request->has('cart') ? 'cart.*.price' : 'productsInCart.*.price' => 'required|numeric',
            $request->has('cart') ? 'cart.*.qty' : 'productsInCart.*.qty' => 'required|integer',
        ]);

        // Proceed with $cartData


        // Calculate total amount
        $totalAmount = collect($cartData)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });

        // Generate a unique invoice code based on the last number
        $lastInvoice = Invoice::orderBy('created_at', 'desc')->first();
        $lastNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_code, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $invoiceCode = 'INV-' . now()->format('Ym') . $newNumber;
        $salesPersonId = $request->salesId ? $request->salesId : null;
        $expireDate = now()->addMinutes(60);

        $salesData = SalesPerson::where('id', $salesPersonId)->first();

        // Create the invoice
        $invoice = Invoice::create([
            'invoice_code' => $invoiceCode,
            'amount' => $totalAmount,
            'status' => 'unpaid',
            'date' => now()->toDateString(),
            'expire_date' => $expireDate,
            'inv_type' => 'transaction',
            'sales_person_id' => $salesPersonId,
            'sales_commission' => $salesData->commission ?? null,
        ]);
       

        // Create invoice details
        foreach ($cartData as $item) {
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
            'status' => 'success',
            'message' => 'Invoice created successfully.',
            'invoice_code' => $invoiceCode,
            'customer_code' => $customer->customer_code
        ]);
    }

    public function editInvoiceAdmin(Invoice $invoice)
    {
        if ($invoice->inv_type == 'transaction'){
            return view('admin.edit_invoice', compact('invoice'));
        } else {
            return view('admin.create_invoice_manual', compact('invoice'));
        }
    }

    public function updateInvoice(Request $request, Invoice $invoice) 
    {
        // Validate the input data
        $request->validate([
            'productsInCart' => 'required|array',
            'productsInCart.*.id' => 'required|integer',
            'productsInCart.*.name' => 'required|string',
            'productsInCart.*.price' => 'required|numeric',
            'productsInCart.*.qty' => 'required|integer',
        ]);

        $cartData = $request->input('productsInCart');

        // Calculate the total amount
        $totalAmount = collect($cartData)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });

        $salesPersonId = $request->salesId ? $request->salesId : null;

        $salesData = SalesPerson::where('id', $salesPersonId)->first();

        // Update the invoice details
        $invoice->update([
            'amount' => $totalAmount,
            'status' => $request->input('status', $invoice->status), // Optional status update
            'expire_date' => $request->input('expireDate') ? $request->expireDate : $invoice->expire_date,
            'sales_person_id' => $salesPersonId,
            'sales_commission' => $request->commission,
            'tax' => $request->tax,
            'fee' => $request->fee,
            'netto' => $request->netto,
            'payment_by' => $request->paymentBy,
        ]);

        // Delete old invoice details
        $invoice->invoice_detail()->delete();

      
        // Insert updated invoice details
        foreach ($cartData as $item) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Invoice updated successfully.',
            'invoice_code' => $invoice->invoice_code
        ]);
    }

    public function updateInvoiceManual(Request $request, Invoice $invoice) 
    {
        $salesPersonId = $request->salesId ? $request->salesId : null;

        $invoice->update([
            'amount' => $request->amount,
            'sales_person_id' => $salesPersonId,
            'sales_commission' => $request->commission,
            'tax' => $request->tax,
            'fee' => $request->fee,
            'netto' => $request->netto,
            'payment_by' => $request->paymentBy,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Invoice updated successfully.',
            'invoice_code' => $invoice->invoice_code
        ]); 
    }

    public function checkout(Request $request)
    {
        
        // Find the invoice by code
        $invoice = Invoice::where('invoice_code', $request->invoice_code)->first();

        $customer = Customer::where('customer_code', $request->customer_code)->first();

        return view('page.linkbayar', compact('invoice', 'customer'));
    }
    
}
