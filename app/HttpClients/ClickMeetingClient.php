<?php

namespace App\HttpClients;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ClickMeetingClient
{
    private const API_BASE_URI = 'https://api.clickmeeting.com/v1/';
    private const API_CONFERENCES = 'conferences';
    private const API_AUTOLOGIN_HASH = 'room/autologin_hash';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var Client
     */
    private $httpClient;

    public function __construct()
    {
        $this->apiKey = config('clickmeeting.api_key');
        $this->httpClient = new Client([
            'http_errors' => false,
            'headers' => [
                'X-Api-Key' => $this->apiKey
            ]
        ]);
    }

    public function createConference(array $parameters): ResponseInterface
    {
        $uri = self::API_BASE_URI . self::API_CONFERENCES;

        return $this->httpClient->request('POST', $uri, [
            'form_params' => $parameters
        ]);
    }

    public function createConferenceAutologinHash(string $roomId, array $parameters): ResponseInterface
    {
        $uri = self::API_BASE_URI . implode('/', [self::API_CONFERENCES, $roomId, self::API_AUTOLOGIN_HASH]);

        return $this->httpClient->request('POST', $uri, [
            'form_params' => $parameters
        ]);
    }
}
