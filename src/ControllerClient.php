<?php

namespace Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Controller\Exceptions\ControllerException;

class ControllerClient
{
    protected $apiKey;
    protected $endpoint;
    protected $httpClient;

    public function __construct(?string $apiKey = null, ?string $endpoint = null)
    {
        $this->apiKey = $apiKey ?? env('CONTROLLER_API_KEY');
        $this->endpoint = $endpoint ?? env('CONTROLLER_ENDPOINT');

        if (empty($this->apiKey)) {
            throw new ControllerException('API key is required.');
        }

        $this->httpClient = new Client();
    }

    public function captureException(\Throwable $exception, array $context = []): void
    {
        $payload = [
            'title' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
            'context' => $context,
        ];

        try {
            $this->httpClient->post($this->endpoint, [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);
        } catch (RequestException $e) {
            error_log('Failed to send issue to Controller.dev: ' . $e->getMessage());
        }
    }
}
