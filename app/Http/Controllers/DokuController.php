<?php

namespace App\Http\Controllers;

use App\Models\ApiService;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DokuController extends Controller
{
    public function getRequestIdAndTimestamp()
    {
        $requestId = bin2hex(random_bytes(8));
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');

        return [
            'request_id' => $requestId,
            'timestamp' => $timestamp
        ];
    }

    public function getSignature($endpoint, $jsonBody = null, $requestAtt, $apiService)
    {
        $clientId = $apiService->attribute['client_id'];
        $apiKey = $apiService->attribute['api_key'];

        // Calculate the digest (SHA-256 hash of the JSON body, if provided)
        if ($jsonBody != null) {
            $digest = base64_encode(hash('sha256', $jsonBody, true));
        } else {
            $digest = '';
        }

        // Construct the string to sign
        $stringToSign = "Client-Id:{$clientId}\nRequest-Id:{$requestAtt['request_id']}\nRequest-Timestamp:{$requestAtt['timestamp']}\nRequest-Target:$endpoint";
        if ($digest !== '') {
            $stringToSign .= "\nDigest:$digest";
        }

        // Calculate HMAC-SHA256 signature using API key
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $apiKey, true));

        // Return the final signature header
        return "HMACSHA256=$signature";
    }

    public function getHeader($signature, $requestAtt, $apiService)
    {
        $clientId = $apiService->attribute['client_id'];
        return [
            "Client-Id: {$clientId}",
            "Request-Id: {$requestAtt['request_id']}",
            "Request-Timestamp: {$requestAtt['timestamp']}",
            "Signature: $signature",
            "Content-Type: application/json"
        ];
    }

    public function initiate()
    {
        $apiService = ApiService::where('name', 'Doku')->firstOrFail();

        $invoice = Invoice::where('invoice_code', 'INV-2025010002')->first();

        $lineItems = $invoice->invoice_detail->map(function ($detail) {
            return [
                "name" => $detail->product_name,
                "price" => $detail->price,
                "quantity" => $detail->qty
            ];
        })->toArray();

        $endpoint = "/credit-card/v1/payment-page";
        $body = json_encode([
            "order" => [
                "invoice_number" => $invoice->invoice_code,
                "amount" => $invoice->amount,
                "line_items" => $lineItems,
                "callback_url" => route('doku-callback') . '?inv_code=' . $invoice->invoice_code,
                "auto_redirect" => true,
                "descriptor" => "Test Descriptor"
            ]
        ]);

        $requestAtt = $this->getRequestIdAndTimestamp();
        $signature = $this->getSignature($endpoint, $body, $requestAtt, $apiService);
        $headers = $this->getHeader($signature, $requestAtt, $apiService);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiService->attribute['base_url'] . $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return response()->json(['error' => $error], 500);
        }

        return response()->json(['response' => json_decode($response, true)], 200);
    }

    public function getTransactionStatus(Request $request)
    {
        $invoice = Invoice::where('invoice_code', $request->inv_code)->first();
        $apiService = ApiService::where('name', 'Doku')->firstOrFail();

        $endpoint = "/orders/v1/status/$request->inv_code";

        $requestAtt = $this->getRequestIdAndTimestamp();

        $signature = $this->getSignature($endpoint, null, $requestAtt, $apiService);

        $headers = $this->getHeader($signature, $requestAtt, $apiService);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiService->attribute['base_url'] . $endpoint);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $result = json_decode($response);

        if ($result->transaction->status == "SUCCESS") {
            $invoice->status = "paid";
            $invoice->payment_by = $result->service->id;
            $invoice->api_status = $response;
            $invoice->save();
        
            return redirect()->to('http://127.0.0.1/payment-app/link-bayar-success');
            
        } else if ($result->transaction->status == "PENDING") {
            return redirect()->to('http://127.0.0.1/payment-app/link-bayar-pending');
        } else {
            return redirect()->to('http://127.0.0.1/payment-app/link-bayar-failed');
        }

    }

    public function initiateCardPayment(Request $request)
    {
        $apiService = ApiService::where('name', 'Doku')->firstOrFail();

        $invoice = Invoice::where('invoice_code', $request->inv_code)->first();

        $lineItems = $invoice->invoice_detail->map(function ($detail) {
            return [
                "name" => $detail->product_name,
                "price" => $detail->price,
                "quantity" => $detail->qty
            ];
        })->toArray();

        $endpoint = "/credit-card/v1/payment-page";
        $body = json_encode([
            "order" => [
                "invoice_number" => $invoice->invoice_code,
                "amount" => $invoice->amount,
                "line_items" => $lineItems,
                "callback_url" => route('doku-callback') . '?inv_code=' . $invoice->invoice_code,
                "auto_redirect" => true,
                "descriptor" => "Test Descriptor"
            ]
        ]);

        $requestAtt = $this->getRequestIdAndTimestamp();
        $signature = $this->getSignature($endpoint, $body, $requestAtt, $apiService);
        $headers = $this->getHeader($signature, $requestAtt, $apiService);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiService->attribute['base_url'] . $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return response()->json(['error' => $error], 500);
        }

        return response()->json(['response' => json_decode($response, true)], 200);
    }

    public function callback(Request $request)
    {
        return $request;
    }
}
