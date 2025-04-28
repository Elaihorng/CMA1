<?php
return [
    'merchant_id'          => env('PAYWAY_MERCHANT_ID', 'ec450051'),
    'api_key'              => env('PAYWAY_API_KEY', 'eff828a3d2ddd32adb5a039b15292c3b786f3ff3'),
    'rsa_public_key_path'  => env('PAYWAY_RSA_PUBLIC_KEY_PATH', 'storage/payway/rsa_public.pem'),
    'rsa_private_key_path' => env('PAYWAY_RSA_PRIVATE_KEY_PATH', 'storage/payway/rsa_private.pem'),
    'api_url'              => env('PAYWAY_API_URL', 'https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase'),
];
