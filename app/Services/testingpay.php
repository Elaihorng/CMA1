<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use phpseclib3\Crypt\RSA;

class testingpay
{
    public function createTransaction($paymentData)
    {
        // Encrypt data using the RSA private key
        $privateKey = '-----BEGIN RSA PRIVATE KEY----- ... -----END RSA PRIVATE KEY-----';
        $rsa = RSA::load($privateKey);
        $encryptedData = $rsa->encrypt(json_encode($paymentData));

        // Send request to PayWay API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer YOUR_API_TOKEN'  // If required
        ])->post('https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase', [
            'data' => base64_encode($encryptedData)  // Assuming PayWay expects encrypted data in base64 format
        ]);

        // Return response to controller
        return $response;
    }
}
