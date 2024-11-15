<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SinchService
{
    private string $apiKey;
    private string $apiSecret;
    private HttpClientInterface $httpClient;
    private string $numPerso;

    public function __construct(string $apiKey, string $apiSecret, HttpClientInterface $httpClient, string $numPerso)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->httpClient = $httpClient;
        $this->numPerso = $numPerso;
    }

    public function sendVerificationSms(): array
    {
        $url = 'https://verification.api.sinch.com/verification/v1/verifications';

        $smsVerificationPayload = [
            'identity' => [
                'type' => 'number',
                'endpoint' => $this->numPerso,
            ],
            'method' => 'sms',
        ];

        try {
            $response = $this->httpClient->request('POST', $url, [
                'auth_basic' => [$this->apiKey, $this->apiSecret],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept-Language' => 'fr-FR',
                ],
                'json' => $smsVerificationPayload,
            ]);

            return [
                'status_code' => $response->getStatusCode(),
                'response' => $response->toArray(false),
            ];
        } catch (\Exception $e) {
            throw new \Exception('Failed to send verification SMS: ' . $e->getMessage());
        }
    }

    public function checkVerificationCode(string $code): bool
    {
        $url = 'https://verification.api.sinch.com/verification/v1/verifications/number/' . $this->numPerso;

        $smsVerificationPayload = [
            'method' => 'sms',
            'sms' => [
                'code' => $code,
            ],
        ];

        try {
            $response = $this->httpClient->request('PUT', $url, [
                'auth_basic' => [$this->apiKey, $this->apiSecret],
                'json' => $smsVerificationPayload,
            ]);

            $data = $response->toArray(false);

            return isset($data['status']) && $data['status'] === 'SUCCESSFUL';

        } catch (\Exception $e) {
            throw new \Exception('Failed to verify SMS code: ' . $e->getMessage());
        }
    }
}
