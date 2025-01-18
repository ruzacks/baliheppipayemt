<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FasPayController extends Controller
{
    public function initiate()
    {
        $tranid = date("YmdGis");
        $signaturecc = sha1('##' . strtoupper('faspay_trial_4') . '##' . strtoupper('ApIbh') . '##' . $tranid . '##1000.00##' . '0' . '##');

        // Define the post data
        $post = array(
            "PAYMENT_METHOD"                => '1',
            "MERCHANTID"                    => 'faspay_trial_4',
            "MERCHANT_TRANID"               => $tranid,
            "CURRENCYCODE"                  => 'IDR',
            "AMOUNT"                        => '1000.00',
            "SIGNATURE"                     => $signaturecc,
            "CUSTNAME"                      => 'John Doe',
            "CUSTEMAIL"                     => 'john@gmail.com',
            "DESCRIPTION"                   => 'Faber Castell Pencil',
            "RESPONSE_TYPE"                 => '2',
            "RETURN_URL"                    => route('faspay-callback'),
            "CARDNO"                        => '4440000009900010',
            "CARDNAME"                      => 'faspay',
            "CARDTYPE"                      => 'V',
            "EXPIRYMONTH"                   => '01',
            "EXPIRYYEAR"                    => '2039',
            "CARDCVC"                       => '100',
            "BILLING_ADDRESS"               => 'Jl. pintu air raya',
            "BILLING_ADDRESS_CITY"          => 'Jakarta',
            "BILLING_ADDRESS_REGION"        => 'DKI Jakarta',
            "BILLING_ADDRESS_STATE"         => 'DKI Jakarta',
            "BILLING_ADDRESS_POSCODE"       => '10710',
            "BILLING_ADDRESS_COUNTRY_CODE"  => 'ID',
            "RECEIVER_NAME_FOR_SHIPPING"    => 'John Doe',
            "SHIPPING_ADDRESS"              => 'Jl. pintu air raya',
            "SHIPPING_ADDRESS_CITY"         => 'Jakarta',
            "SHIPPING_ADDRESS_REGION"       => 'DKI Jakarta',
            "SHIPPING_ADDRESS_STATE"        => 'DKI Jakarta',
            "SHIPPING_ADDRESS_POSCODE"      => '10710',
            "SHIPPING_ADDRESS_COUNTRY_CODE" => 'ID',
            "PHONE_NO"                      => '0897867688989',
            "style_merchant_name"           => 'black',
            "style_order_summary"           => 'black',
            "style_order_no"                => 'black',
            "style_order_desc"              => 'black',
            "style_amount"                  => 'black',
            "style_background_left"         => '#fff',
            "style_button_cancel"           => 'grey',
            "style_font_cancel"             => 'white',
            "style_image_url"               => 'http://url_merchant/image.png',
        );

        // Start generating the HTML form
        $string = '<form method="post" name="form" action="https://fpg-sandbox.faspay.co.id/payment">';

        if ($post != null) {
            foreach ($post as $name => $value) {
                $string .= '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '">';
            }
        }

        $string .= '</form>';
        $string .= '<script>document.form.submit();</script>';

        // Output the form for automatic submission
        echo $string;
        exit;

    }

    public function initiateKredivo()
    {
        // User credentials
        $user_id = 'bot50004';
        $pass = 'airGZSnd';

        // Generate bill number and signature
        $bill_no = uniqid(); // Generate a unique bill number
        $signature = sha1(md5($user_id . $pass . $bill_no));

        // Set the current date and time for the bill
        $bill_date = date("Y-m-d H:i:s");
        $bill_expired = date("Y-m-d H:i:s", strtotime("+1 hour")); // Expired 1 hour from now

        // Prepare the JSON payload
        $data = [
            "request"                     => "Post Data Transaction",
            "merchant_id"                 => "faspay_trial_4",
            "merchant"                    => "Sophia Store",
            "bill_no"                     => $bill_no,
            "bill_reff"                   => "12345678",
            "bill_date"                   => $bill_date,
            "bill_expired"                => $bill_expired,
            "bill_desc"                   => "Payment #12345678",
            "bill_currency"               => "IDR",
            "bill_gross"                  => "0",
            "bill_miscfee"                => "0",
            "bill_total"                  => "1000000",
            "cust_no"                     => "12",
            "cust_name"                   => "John Doe",
            "payment_channel"             => "302",
            "pay_type"                    => "1",
            "bank_userid"                 => "",
            "msisdn"                      => "081513114262",
            "email"                       => "john@gmail.com",
            "terminal"                    => "10",
            "billing_name"                => "0",
            "billing_lastname"            => "0",
            "billing_address"             => "jalan pintu air raya",
            "billing_address_city"        => "Jakarta Pusat",
            "billing_address_region"      => "DKI Jakarta",
            "billing_address_state"       => "Indonesia",
            "billing_address_poscode"     => "10710",
            "billing_msisdn"              => "",
            "billing_address_country_code"=> "ID",
            "receiver_name_for_shipping"  => "John Doe",
            "shipping_lastname"           => "",
            "shipping_address"            => "jalan pintu air raya",
            "shipping_address_city"       => "Jakarta Pusat",
            "shipping_address_region"     => "DKI Jakarta",
            "shipping_address_state"      => "Indonesia",
            "shipping_address_poscode"    => "10710",
            "shipping_msisdn"             => "",
            "shipping_address_country_code"=> "ID",
            "item"=>  [
                "id"=>  "A001",
                "product"=>  "Iphone 12",
                "qty"=>  "1",
                "amount"=>  "100000",
                "type"=>  "Smartphone",
                "merchant_id"=> "K0001",
                "url"=>  "https=> //your_website/merchant",
                "image_url"=>  "https://your_image_url/image.jpg"
            ],
            "reserve1"                    => "",
            "reserve2"                    => "",
            // "signature"                   => $signature
        ];

        // API endpoint
        $url = "https://debit-sandbox.faspay.co.id/cvr/300011/10";

        // Initialize cURL
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Request Error: ' . curl_error($ch);
        } else {
            // Print the response
            echo $response;
        }

        // Close cURL
        curl_close($ch);
    }

    public function callback(Request $request)
    {
        return $request;
    }
    
}
