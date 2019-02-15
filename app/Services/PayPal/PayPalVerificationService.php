<?php

namespace App\Services\PayPal;

use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;

class PayPalVerificationService extends PayPalService
{
    private const PAYMENT_STATUS_VERIFIED = "VERIFIED";

    public function isPaymentVerified(string $paymentId): bool
    {
        try {
            $payment = Payment::get($paymentId, $this->apiContext);
            return $payment->getPayer()->getStatus() ==  self::PAYMENT_STATUS_VERIFIED;
        } catch (PayPalConnectionException $ex) {
            return false;
        }
    }
}
