<?php

namespace App\Http\Controllers;

use App\HttpClients\ClickMeetingClient;
use App\Services\ClickMeeting\ClickMeetingConferenceService;
use App\Services\PayPal\PayPalVerificationService;
use Illuminate\Http\RedirectResponse;

class PaidConferenceController extends Controller
{
    /**
     * @var ClickMeetingConferenceService
     */
    private $conferenceService;

    /**
     * @var PayPalVerificationService
     */
    private $verificationService;

    public function __construct(ClickMeetingClient $clickMeetingClient, PayPalVerificationService $verificationService)
    {
        $this->conferenceService = new ClickMeetingConferenceService($clickMeetingClient);
        $this->verificationService = $verificationService;
    }

    public function createPaidConference(string $email, string $nickname, string $paymentId): RedirectResponse
    {
        if ($this->verificationService->isPaymentVerified($paymentId)) {
            $this->conferenceService->setUserCredentials([
                'email' => $email,
                'nickname' => $nickname,
                'role' => config('conference.default_role')
            ]);
            $url = $this->conferenceService->getAutoliginUrlForPaidConference();

            if ($url) {
                return redirect($url);
            }
        }

        return redirect()->route('home')
            ->with('error', 'Cannot create room');
    }
}
