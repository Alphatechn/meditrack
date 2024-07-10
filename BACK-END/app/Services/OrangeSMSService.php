<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OrangeSMSService
{
    protected $client;
    protected $apiKey;
    protected $apiSecret;
    protected $senderPhone;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('CLIENT_ID');
        $this->apiSecret = env('CLIENT_SECRET');
        $this->senderPhone = env('CLIENT_SENDER');
    }

    private function getToken()
    {
        $response = $this->client->post('https://api.orange.com/oauth/v3/token', [
            'auth' => [$this->apiKey, $this->apiSecret],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        return $body['access_token'];
    }

    public function sendSMS($recipient, $message)
    {
        $token = $this->getToken();
        $response = $this->client->post('https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B' . $this->senderPhone . '/requests', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'outboundSMSMessageRequest' => [
                    'address' => 'tel:+237' . $recipient,
                    'senderAddress' => 'tel:+237' . $this->senderPhone,
                    'outboundSMSTextMessage' => [
                        'message' => $message
                    ]
                ]
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
