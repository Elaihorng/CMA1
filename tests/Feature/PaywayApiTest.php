<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaywayApiTest extends TestCase
{
    public function testPaymentRequest()
    {
        // Send form data instead of JSON
        $response = $this->withoutMiddleware()
        ->postJson('/api/payment/initiating', [
                'req_time' => '20250420175815',
                'merchant_id' => 'ec450051',
                'tran_id' => 'tran_680535b7c4abb',
                'amount' => 55500.0,
                'firstname' => 'jennie',
                'lastname' => 'jennie',
                'email' => 'jennie@gmail.com',
                'phone' => '078949292',
                'currency' => 'USD',
                // Add any other fields you need here
            ]);

        // Dump the response content for debugging
        dump($response->getContent());

        // Ensure you get the correct response
        $response->assertStatus(200);
        $response->assertJson([
            'error' => 'Payment URL not provided by PayWay.',
        ]);
    }
}
