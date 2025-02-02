<?php

namespace App\Http\Controllers;

use App\Models\ApiService;
use App\Models\Customer;
use App\Models\FeeSetting;
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
            $invoice->payment_by = $result->acquirer->id;
            $invoice->netto = $this->calculateDokuNetto($result->acquirer->id, $result->order->amount, $result->channel->id);
            $invoice->api_status = $response;

            // First check for FeeSetting based on acquirer id
            $fee = FeeSetting::where('method_name', strtolower($result->acquirer->id))->first();

            // If FeeSetting for acquirer id doesn't exist, use the channel id
            strtolower($result->channel->id) === 'credit_card' ? $methodName = 'Kartu Kredit' : $methodName = $result->channel->id;
            if (!$fee) {
                $fee = FeeSetting::where('method_name', strtolower($methodName))->first();
            }

            // Assuming $fee exists at this point, set tax and fee
            if ($fee) {
                $invoice->tax = $fee->tax_percentage;
                $invoice->fee = $fee->rajagestun_fee;
            }

            // Save the invoice
            $invoice->save();

            return redirect()->to('http://127.0.0.1/linkbayar/success.php');
        } else if ($result->transaction->status == "PENDING") {
            $invoice->payment_by = $result->acquirer->id;
            $invoice->api_status = $response;
            $invoice->status = 'pending';
            $invoice->save();
            return redirect()->to("http://127.0.0.1/linkbayar/pending.php?inv_code=$invoice->invoice_code");
        } else {
            $invoice->payment_by = $result->acquirer->id;
            $invoice->api_status = $response;
            $invoice->save();
            return redirect()->to('http://127.0.0.1/linkbayar/failed.php');
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

    public function initiateAkulaku()
    {
        $apiService = ApiService::where('name', 'Doku')->firstOrFail();

        $invoice = Invoice::where('invoice_code', 'INV-2025010006')->first();

        $lineItems = $invoice->invoice_detail->map(function ($detail) {
            return [
                "name" => $detail->product_name,
                "price" => $detail->price,
                "quantity" => $detail->qty,
                "sku" => "kerupuk-kulit",
                "category" => "food"
            ];
        })->toArray();

        $endpoint = "/akulaku-peer-to-peer/v2/generate-order";
        $body = json_encode([
            "order" => [
                "invoice_number" => $invoice->invoice_code,
                "amount" => intval($invoice->amount),
                "line_items" => $lineItems,
                "callback_url" => route('doku-callback') . '?inv_code=' . $invoice->invoice_code,
                "auto_redirect" => true,
                "descriptor" => "Test Descriptor"
            ],
            "payment" => [
                "merchant_unique_reference" => $invoice->invoice_code . random_int(1, 100)
            ],
            "customer" => [
                "id" => "CUST-0001",
                "name" => "Anton Budiman",
                "phone" => "6285694566147",
                "address" => "Menara Mulia Lantai 8",
                "city" => "Jakarta Selatan",
                "state" => "DKI Jakarta",
                "postcode" => "120129"
            ],
        ]);

        // return json_decode($body);

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

    public function initiateKredivo()
    {
        $apiService = ApiService::where('name', 'Doku')->firstOrFail();

        $invoice = Invoice::where('invoice_code', 'INV-2025010006')->first();

        $lineItems = $invoice->invoice_detail->map(function ($detail) {
            return [
                "name" => $detail->product_name,
                "price" => $detail->price,
                "quantity" => $detail->qty,
                "id" => strval($detail->product_id),
                "type" => "food",
                "url" => route('product-single', $detail->product_id)
            ];
        })->toArray();

        $endpoint = "/kredivo-peer-to-peer/v2/generate-order";
        $body = json_encode([
            "order" => [
                "invoice_number" => $invoice->invoice_code,
                "amount" => intval($invoice->amount), //currently it .00 at the end how to remove that?
                "line_items" => $lineItems,
                "callback_url" => route('doku-callback') . '?inv_code=' . $invoice->invoice_code,
                "auto_redirect" => true,
                "descriptor" => "Test Descriptor"
            ],
            "peer_to_peer_info" => [
                "merchant_unique_reference" => $invoice->invoice_code
            ],
            "customer" => [
                "first_name" => "andreas",
                "last_name" => "dharmawan",
                "phone" => "081398154809",
                "email" => "andreas@email.com"
            ],
            "shipping_address" => [
                "first_name" => "andreas",
                "last_name" => "dharmawan",
                "address" => "Jalan Teknologi Indonesia No. 25",
                "city" => "Jakarta",
                "postal_code" => "12960",
                "phone" => "081513114262",
                "country_code" => "IDN"
            ],
        ]);

        // return json_decode($body);

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

    public function initiateIndodana()
    {
        $apiService = ApiService::where('name', 'Doku')->firstOrFail();

        $invoice = Invoice::where('invoice_code', 'INV-2025010009')->first();

        $lineItems = $invoice->invoice_detail->map(function ($detail) {
            return [
                "name" => $detail->product_name,
                "price" => $detail->price,
                "quantity" => $detail->qty,
                "id" => strval($detail->product_id),
                "category" => "food-retail-and-service",
                // "url" => route('product-single', $detail->product_id)
            ];
        })->toArray();

        $endpoint = "/indodana-peer-to-peer/v2/generate-order";
        $body = json_encode([
            "order" => [
                "invoice_number" => "MINV20201231468" . uniqid(),
                "line_items" => [
                    [
                        "name" => "Ayam",
                        "price" => 50000,
                        "quantity" => 2,
                        "id" => "1002",
                        "category" => "food-retail-and-service",
                        // "url" => "https://merchant.com/product_1002",
                        // "image_url" => "https://merchant.com/product_1002/image",
                        "type" => "handphone"
                    ]
                ],
                "amount" => 100000,
                "callback_url" => "https://soojabali.com/return-url",
                // "callback_url_cancel" => "https://merchant.com/cancel-url"
            ],
            "peer_to_peer_info" => [
                "expired_time" => 60,
                "merchant_unique_reference" => "60123" . uniqid()
            ],
            "customer" => [
                "first_name" => "andreas",
                "last_name" => "dharmawan",
                "phone" => "62838499610",
                "email" => "andreas@email.com"
            ],
            "billing_address" => [
                "first_name" => "andreas",
                "last_name" => "dharmawan",
                "address" => "Jalan Teknologi Indonesia No. 25",
                "city" => "Jakarta",
                "postal_code" => "12960",
                "phone" => "62838499610",
                "country_code" => "IDN"
            ],
            "shipping_address" => [
                "first_name" => "andreas",
                "last_name" => "dharmawan",
                "address" => "Jalan Teknologi Indonesia No. 25",
                "city" => "Jakarta",
                "postal_code" => "12960",
                "phone" => "62838499610",
                "country_code" => "IDN"
            ],
            "additional_info" => [
                "override_notification_url" => "https://another.example.com/payments/notifications"
            ]
        ]);

        // return json_decode($body);

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

    public function initiatePaylaterPayment(Request $request)
    {

        $apiService = ApiService::where('name', 'Doku')->firstOrFail();

        $invoice = Invoice::where('invoice_code', $request['inv_code'])->first();

        if ($request['cust_data']['provider'] == 'akulaku') {
            $endpoint = "/akulaku-peer-to-peer/v2/generate-order";
            $body = $this->generateAkulakuBody($invoice, $request['cust_data']);
        } else if ($request['cust_data']['provider'] == 'kredivo') {
            $endpoint = "/kredivo-peer-to-peer/v2/generate-order";
            $body = $this->generateKredivoBody($invoice, $request['cust_data']);
        }

        // return json_decode($body);

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

    public function generateAkulakuBody($invoice, $custData)
    {
        // Check if customer exists; if not, create a new one
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

        // Map invoice details into line items
        $lineItems = $invoice->invoice_detail->map(function ($detail) {
            return [
                "name" => $detail->product_name,
                "price" => $detail->price,
                "quantity" => $detail->qty,
                "sku" => "kerupuk-kulit",
                "category" => "food"
            ];
        })->toArray();

        // Build the request body
        $body = json_encode([
            "order" => [
                "invoice_number" => $invoice->invoice_code,
                "amount" => intval($invoice->amount),
                "line_items" => $lineItems,
                "callback_url" => route('doku-callback') . '?inv_code=' . $invoice->invoice_code,
                "auto_redirect" => true,
                "descriptor" => "Test Descriptor"
            ],
            "payment" => [
                "merchant_unique_reference" => $invoice->invoice_code . uniqid()
            ],
            "customer" => [
                "id" => $customer->customer_code,
                "name" => $customer->first_name . ' ' . $customer->last_name,
                "phone" => $customer->phone,
                "address" => $customer->address,
                "city" => $customer->city,
                "state" => $customer->state,
                "postcode" => $customer->postcode
            ],
        ]);

        return $body;
    }

    public function generateKredivoBody($invoice, $custData)
    {
        // Check if customer exists; if not, create a new one
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

        // Map invoice details into line items
        $lineItems = $invoice->invoice_detail->map(function ($detail) {
            return [
                "name" => $detail->product_name,
                "price" => $detail->price,
                "quantity" => $detail->qty,
                "id" => strval($detail->product_id),
                "type" => "food",
                "url" => route('product-single', $detail->product_id)
            ];
        })->toArray();

        // Build the request body
        $body = json_encode([
            "order" => [
                "invoice_number" => $invoice->invoice_code,
                "amount" => intval($invoice->amount), //currently it .00 at the end how to remove that?
                "line_items" => $lineItems,
                "callback_url" => route('doku-callback') . '?inv_code=' . $invoice->invoice_code,
                "auto_redirect" => true,
                "descriptor" => "Test Descriptor"
            ],
            "peer_to_peer_info" => [
                "merchant_unique_reference" => $invoice->invoice_code . uniqid()
            ],
            "customer" => [
                "first_name" => $customer->first_name,
                "last_name" => $customer->last_name,
                "phone" => $customer->phone,
                "email" => $customer->email
            ],
            "shipping_address" => [
                "first_name" => $customer->first_name,
                "last_name" => $customer->last_name,
                "address" => $customer->address,
                "city" => $customer->city,
                "postal_code" => $customer->postcode,
                "phone" => $customer->phone,
                "country_code" => "IDN"
            ],
        ]);

        return $body;
    }

    public function calculateDokuNetto($aquirer, $amount, $channel)
    {
        // Fetch the JSON from the URL
        $feeJsonUrl = 'https://cdn-doku.oss-ap-southeast-5.aliyuncs.com/doku-com/simulator_pricing.json';
        $feeJson = json_decode(file_get_contents($feeJsonUrl));

        // dd($feeJson);

        // Convert channel to lowercase for consistent comparison
        $aquirer = strtolower($aquirer);
        $channel = strtolower($channel);

        // Variables for fee calculation
        $percentage = 0;
        $additional = 0;

        // Determine fee percentage and additional fee based on the channel
        if (in_array($aquirer, ['akulaku', 'kredivo', 'indodana'])) {
            $percentage = $feeJson->percentage->paylater->$aquirer ?? 0;
            $additional = $feeJson->additional_fee->paylater->$aquirer ?? 0;
        } elseif ($channel === 'credit_card') {
            $percentage = $feeJson->percentage->credit_card->visa_mc_jcb ?? 0;
            $additional = $feeJson->additional_fee->credit_card->visa_mc_jcb ?? 0;
        }

        // Calculate fee and taxes
        $fee = ($amount * $percentage / 100) + $additional;
        $taxes = $fee * 0.11; // 11% tax

        // Calculate netto
        $netto = $amount - $fee - $taxes;

        return $netto;
    }
}
