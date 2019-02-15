<?php

namespace App\Http\Controllers;

use App\Services\PayPal\PayPalExecutionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentExecutionController extends Controller
{
    /**
     * @var PayPalExecutionService
     */
    private $executionService;

    public function __construct(PayPalExecutionService $service)
    {
        $this->executionService = $service;
    }

    public function executePayment(string $email, string $nickname, Request $request): RedirectResponse
    {
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        if ($payerId && $paymentId) {
            $payment = $this->executionService->executePayment($paymentId, $payerId);

            if ($payment->getId()) {
                return redirect()->route('paidConferenceCreation', [
                    'paymentId' => $paymentId,
                    'email' => $email,
                    'nickname' => $nickname
                ]);
            }
        }

        return redirect()->route('home')
            ->with('error', 'Payment cannot be verified');
    }
}
