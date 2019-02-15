<?php

namespace App\Services\ClickMeeting;

use App\HttpClients\ClickMeetingClient;

abstract class ClickMeetingService
{
    /**
     * @var ClickMeetingClient
     */
    protected $client;

    public function __construct(ClickMeetingClient $client)
    {
        $this->client = $client;
    }
}
