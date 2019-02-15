<?php

namespace App\Services\ClickMeeting;

use App\HttpClients\ClickMeetingClient;

class ClickMeetingConferenceService extends ClickMeetingService
{
    /**
     * @var array
     */
    private $conferenceDetails;

    /**
     * @var array
     */
    private $userCredentials;

    public function __construct(ClickMeetingClient $client)
    {
        parent::__construct($client);
        $this->conferenceDetails = config('conference.default_room_details');
    }

    public function setConferenceDetails(array $details): void
    {
        $this->conferenceDetails = $details;
    }

    public function setUserCredentials(array $credentials): void
    {
        $this->userCredentials = $credentials;
    }

    public function getAutoliginUrlForPaidConference(): ?string
    {
        $conferenceResponse = $this->client->createConference($this->conferenceDetails);

        if ($conferenceResponse->getStatusCode() == 201) {
            $conferenceResponseBody = json_decode($conferenceResponse->getBody()->getContents());
            $roomId = $conferenceResponseBody->room->id;
            $roomUrl = $conferenceResponseBody->room->room_url;
            $autologinResponse = $this->client->createConferenceAutologinHash($roomId, $this->userCredentials);

            if ($autologinResponse->getStatusCode() == 200) {
                $autologinResponseBody = json_decode($autologinResponse->getBody()->getContents());
                $hash = $autologinResponseBody->autologin_hash;

                return $this->makeAutologinUrl($roomUrl, $hash);
            }
        }

        return null;
    }

    private function makeAutologinUrl(string $roomUrl, string $hash): string
    {
        return $roomUrl . '?l=' . $hash;
    }
}
