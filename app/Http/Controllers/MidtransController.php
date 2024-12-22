<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function create(Request $request)
    {
        
        // return $request->token_id;
        \Midtrans\Config::$serverKey = 'SB-Mid-server-lQc-JpETp9bSJVaMNIQ6uqIH';

        $params = array(
            'transaction_details' => array(
                'order_id' =>  $request->invoice_id,
                'gross_amount' => $request->amount,
            ),
            'payment_type' => 'credit_card',
            'credit_card'  => array(
                'token_id'      => $request->token_id,
                'authentication'=> true,
            ),
            // 'customer_details' => array(
            //     'first_name' => 'budi',
            //     'last_name' => 'pratama',
            //     'email' => 'budi.pra@example.com',
            //     'phone' => '08111222333',
            // ),
        );

        $response = \Midtrans\CoreApi::charge($params);

        return $response;
    }

    public function getSnapToken(Request $request)
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-lQc-JpETp9bSJVaMNIQ6uqIH';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $request->invoice_id,
                'gross_amount' => $request->amount,
            ),
            // 'customer_details' => array(
            //     'first_name' => 'budi',
            //     'last_name' => 'pratama',
            //     'email' => 'budi.pra@example.com',
            //     'phone' => '08111222333',
            // ),
        );

        $response = \Midtrans\Snap::getSnapToken($params);

        return $response;
    }

    public function getStatus($trans_id)
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-lQc-JpETp9bSJVaMNIQ6uqIH';

        $response = \Midtrans\Transaction::status($trans_id);

        if ($response->transaction_status == "deny" || $response->transaction_status == "failure" || $response->fraud_status == 'deny') {
            return view('page.failed', compact('response'));
        } else if (($response->transaction_status == "capture" || $response->transaction_status == "settlement") && $response->fraud_status == 'accept') {
            return view('page.success', compact('response'));
        } else if ($response->transaction_status == "pending") {
            return view('page.failed', compact('response'));
        }
    }
}
