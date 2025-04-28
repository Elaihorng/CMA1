<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MailSlurpService
{
    protected $client;
    protected $apiKey;
    protected $inboxId;

    public function __construct()
    {
        $this->apiKey = env('MAILSLURP_API_KEY');
        $this->inboxId = env('MAILSLURP_INBOX_ID');

        // Optional path to your local certificate file (adjust in .env if needed)
        $certPath = env('CURL_CA_CERT_PATH', 'C:/wamp64/bin/php/php8.2.18/extras/ssl/cacert.pem');

        $this->client = new Client([
            'base_uri' => 'https://api.mailslurp.com/',
            'headers' => [
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'verify' => $certPath, // 👈 Use SSL certificate file
        ]);
    }

    /**
     * Send an email using MailSlurp API.
     *
     * @param string $to Recipient email address.
     * @param string $subject Email subject.
     * @param string $body HTML body.
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendEmail($to, $subject, $body)
    {
        try {
            // Ensure $to is a string and a valid email address
            if (!is_string($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("Invalid email address provided: " . print_r($to, true));
            }

            // Send email with the correct payload
            return $this->client->post('sendEmail', [
                'json' => [
                    'inboxId' => $this->inboxId,
                    'to' => $to, // No array, just a string
                    'subject' => $subject,
                    'body' => $body,
                    'isHTML' => true,
                ],
            ]);
        } catch (RequestException $e) {
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            \Log::error("MailSlurp Send Error: " . $e->getMessage() . " | Body: " . $responseBody);
            throw $e;
        }
    }


}
