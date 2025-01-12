<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;

class IpaymuController extends Controller
{
    public function getHeader($requestBody)
    {
        // *Don't change this
        // $va = '0000002214342159'; //get on iPaymu dashboard
        // $apiKey = 'SANDBOX06BF6179-D0EC-460F-B765-59BB69650051'; //get on iPaymu dashboard

        $va = '1179002214342159';
        $apiKey = '91DE0716-DEFD-4208-AAFC-E8B88C44A06B';
        
        $stringToSign = strtoupper('POST') . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp = Date('YmdHis');
        //End Generate Signature
    
        // Request header
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );

        return $headers;
    }

    public function initiate()
    {
        $va = '0000002214342159'; //get on iPaymu dashboard
        $apiKey = 'SANDBOX06BF6179-D0EC-460F-B765-59BB69650051'; //get on iPaymu dashboard
    
        $url = 'https://sandbox.ipaymu.com/api/v2/payment/direct'; // for development mode
        // $url          = 'https://my.ipaymu.com/api/v2/payment/direct'; // for production mode\


        $invoice = Invoice::where('invoice_code', 'INV-2025010002')->first();
    
        // Request Body
        $body['name'] = trim("Putu Made Nyoman Ketut");
        $body['phone'] = trim("081234567890");
        $body['email'] = trim("test@example.com");
        $body['amount'] = floatval($invoice->amount);
        $body['notifyUrl'] = trim('https://your-website.com/callback-url');
        $body['referenceId'] = $invoice->invoice_code; //your reference id
        $body['paymentMethod'] = trim("qris");
        $body['paymentChannel'] = trim("mpm");
        // End Request Body//
    
        // Generate Signature
        // *Don't change this
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper('POST') . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp = Date('YmdHis');
        //End Generate Signature
    
        // Request header
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $response = curl_exec($ch);
        curl_close($ch);
    
        if ($err) {
            print_r($err);
        } else {
            //Response
            return json_decode($response);
            // $responseDecode = json_decode($response);
            //End Response
        }
    }

    public function initiateQRPayment(Request $request)
    {
        $invoice = Invoice::where('invoice_code', $request->inv_code)->first();

        if($invoice->payment_type == 'qris' && $invoice->payment_link != null && $invoice->payment_by = 'IPAYMU'){
            return response()->json([
                'status' => 'success',
                'qr_link' => $invoice->payment_link
            ]);
        }

        
    
        // $url = 'https://sandbox.ipaymu.com/api/v2/payment/direct'; // for development mode
        $url          = 'https://my.ipaymu.com/api/v2/payment/direct'; // for production mode\


    
        // Request Body
        $body['name'] = trim("linkbayar customer");
        $body['phone'] = trim("08111111111");
        $body['email'] = trim("test@example.com");
        $body['amount'] = floatval($invoice->amount);
        $body['notifyUrl'] = route('ipaymuCallback');
        $body['referenceId'] = $invoice->invoice_code; //your reference id
        $body['paymentMethod'] = trim("qris");
        $body['paymentChannel'] = trim("mpm");
        // $body['feeDirection'] = trim('BUYER');
        // End Request Body//
        
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
    
        // Generate Signature
        $headers = $this->getHeader($requestBody);
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $response = curl_exec($ch);
        curl_close($ch);
    
        if ($err) {
            print_r($err);
        } else {
            //Response
            $data = json_decode($response);

            // dd($data);
             
            if ($data->Status === 200 && $data->Success) {

              $invoice->trans_id = $data->Data->TransactionId;
              $invoice->payment_by = 'IPAYMU';
              $invoice->payment_type = 'qris';
              $invoice->payment_link = $data->Data->QrString;
              $invoice->save();

              return response()->json([
                'status' => 'success',
                'qr_link' => $data->Data->QrString
            ]);

            } else {
                // Handle the case if the status is not 200 or success is false
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong with the payment processing.'
                ], 400);
            }
        }
    }

    public function checkPayment(Request $request)
    {
        $invoice = Invoice::where('invoice_code', $request->inv_code)->first();

        // $url = "https://sandbox.ipaymu.com/api/v2/transaction";
        $url = "https://my.ipaymu.com/api/v2/transaction";


        $body['transactionId'] = trim($invoice->trans_id);
        $body['account'] = trim("1179002214342159");
        // $body['account'] = trim("0000002214342159");
        // End Request Body//
        
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));

        $headers = $this->getHeader($requestBody);
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $response = curl_exec($ch);
        curl_close($ch);
    
        if ($err) {
            print_r($err);
        } else {
            //Response
            $data = json_decode($response);

            if ($data->Data->PaidStatus == 'paid') {
                $invoice->status = 'paid';
                $invoice->save();
            
                return response()->json([
                    'status' => 'success',
                    'payment_status' => 'paid',
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'payment_status' => 'unpaid',
                ]);
            }
        }
    }

    public function apiCallback(Request $request)
    {
        $transId = $request->trx_id;

        $invoice = Invoice::where('trans_id', $transId)->first();

        if($invoice){
            $invoice->status = $request->status;
            $invoice->save();
        }

        return true;

    }



}
