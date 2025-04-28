<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaywayService
{
    protected $merchantId;
    protected $apiKey;
    protected $apiUrl;
    protected $privateKeyPath;

    public function __construct()
    {
        $this->merchantId = config('payway.merchant_id');
        $this->apiKey = config('payway.api_key');
        $this->rsaPublicKeyPath = config('payway.rsa_public_key_path');
        $this->rsaPrivateKeyPath = config('payway.rsa_private_key_path');
        $this->apiUrl = config('payway.api_url');

    }

    public function createTransaction(array $paymentData)
    {
        $reqTime = gmdate('YmdHis'); // UTC date and time in YYYYMMDDHHMMSS format
        $tranId = uniqid('tran_');  // Unique transaction ID
    
        // Prepare the payload
        $payload = [
            'req_time'        => $reqTime,
            'merchant_id'     => $this->merchantId,
            'tran_id'         => $tranId,
            'amount'          => $paymentData['amount'] * 100, // Convert amount to cents
            'items'           => json_encode($paymentData['items'] ?? []),
            'shipping'        => '', // Add if applicable
            'firstname'       => $paymentData['first_name'] ?? '',
            'lastname'        => $paymentData['last_name'] ?? '',
            'email'           => $paymentData['email'] ?? '',
            'phone'           => $paymentData['phone'] ?? '',
            'type'            => 'PURCHASE',  // Transaction type
            'payment_option'  => 'card',  // Payment option, e.g., 'card'
            'return_url'      => $paymentData['return_url'],
            'cancel_url'      => $paymentData['cancel_url'],
            'continue_success_url' => $paymentData['continue_success_url'] ?? '',
            'currency'        => $paymentData['currency'],
            'custom_fields'      => json_encode([]), 
            'return_params'      => '',  // Add an empty string for return_params
            'google_pay_token'   => '',  // Add an empty string for google_pay_token
        ];
    
        Log::info('Payment payload:', $payload);
    
        try {
            // Step 1: Load the private key
            $privateKeyPath = base_path(config('payway.rsa_private_key_path'));
            $privateKey = file_get_contents($privateKeyPath);  // Use $privateKeyPath here instead of $this->privateKeyPath
            if (!$privateKey) {
                Log::error("RSA private key file not found at: $privateKeyPath");
                return ['error' => 'RSA private key file not found'];
            }
    
            // Step 2: Create HMAC SHA512 hash for the payload
            $concatenatedValues = implode('', [
                $payload['req_time'],
                $payload['merchant_id'],
                $payload['tran_id'],
                $payload['amount'],
                $payload['items'],
                $payload['shipping'],
                $payload['firstname'],
                $payload['lastname'],
                $payload['email'],
                $payload['phone'],
                $payload['type'],
                $payload['payment_option'],
                $payload['return_url'],
                $payload['cancel_url'],
                $payload['continue_success_url'],
                $payload['currency'],
                $payload['custom_fields'],
                $payload['return_params'],
                $payload['google_pay_token'],
            ]);
    
            // Generate HMAC SHA512 hash with the private key
            $hash = hash_hmac('sha512', $concatenatedValues, $privateKey, true);
            $payload['hash'] = base64_encode($hash);
    
            // Step 3: Send to PayWay
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->post($this->apiUrl, $payload);
    
            Log::info('Payment response from PayWay', ['response' => $response->body()]);
            $responseBody = $response->json();
    
            if (isset($responseBody['payment_url'])) {
                return [
                    'payment_url' => $responseBody['payment_url'],
                    'html' => $responseBody['html'] ?? null,
                ];
            } else {
                Log::error('Error from PayWay API', ['response' => $responseBody]);
                return ['error' => 'Payment URL not provided by PayWay. Please check your PayWay configuration.'];
            }
    
        } catch (\Exception $e) {
            Log::error('PayWay exception', ['message' => $e->getMessage()]);
            return ['error' => 'An unexpected error occurred: ' . $e->getMessage()];
        }
    }
    
}
