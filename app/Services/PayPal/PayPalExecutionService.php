<?php

namespace App\Services\PayPal;

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class PayPalExecutionService extends PayPalService
{
    public function executePayment(string $paymentId, string $payerId): Payment
    {
        try {
            $payment = Payment::get($paymentId, $this->apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            return $payment->execute($execution, $this->apiContext);
        } catch (PayPalConnectionException $ex) {
            return new Payment(null);
        }
    }
}
