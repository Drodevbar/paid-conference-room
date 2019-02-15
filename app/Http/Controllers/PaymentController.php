<?php

namespace App\Http\Controllers;

use App\Services\PayPal\PayPalPaymentService;
use App\Validators\EmailValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @var PayPalPaymentService
     */
    private $paymentService;

    /**
     * @var array
     */
    private $roomPriceDetails;

    /**
     * @var array
     */
    private $redirectUrls;

    public function __construct(PayPalPaymentService $service)
    {
        $this->paymentService = $service;
        $this->roomPriceDetails = config('conference.price');
    }

    public function makePayment(Request $request): RedirectResponse
    {
        $email = $request->get('email');
        $nickname = $request->get('nickname');

        if (EmailValidator::isValid($email) && $nickname) {
            $this->initializeRedirectUrls($email, $nickname);

            $payment = $this->paymentService
                ->setRedirectUrls($this->redirectUrls['success'], $this->redirectUrls['failure'])
                ->setPayer($email)
                ->setPrice($this->roomPriceDetails['value'], $this->roomPriceDetails['currency'])
                ->makePayment();

            if ($payment->getApprovalLink()) {
                return redirect($payment->getApprovalLink());
            }
        }

        return redirect()->route('home')
            ->with('error', 'Invalid credentials');
    }

    private function initializeRedirectUrls(string $email, string $nickname): void
    {
        $this->redirectUrls = [
            'success' => route('paymentExecution', [
                'email' => $email,
                'nickname' => $nickname
            ]),
            'failure' => route('failure')
        ];
    }
}
