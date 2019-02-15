<?php

namespace App\Services\PayPal;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConfigurationException;

class PayPalPaymentService extends PayPalService
{
    /**
     * @var Payer
     */
    private $payer;

    /**
     * @var PayerInfo
     */
    private $payerInfo;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @var RedirectUrls
     */
    private $redirectUrls;

    public function __construct()
    {
        parent::__construct();
        $this->payer = new Payer();
        $this->payerInfo = new PayerInfo();
        $this->amount = new Amount();
        $this->redirectUrls = new RedirectUrls();
    }

    public function setPayer(string $email): self
    {
        $this->payerInfo->setEmail($email);
        return $this;
    }

    public function setPrice(string $price, string $currency): self
    {
        $this->amount->setCurrency($currency)->setTotal($price);
        return $this;
    }

    public function setRedirectUrls(string $success, string $failure): self
    {
        $this->redirectUrls->setReturnUrl($success)->setCancelUrl($failure);
        return $this;
    }

    public function makePayment(): Payment
    {
        $this->payer
            ->setPaymentMethod("paypal")
            ->setPayerInfo($this->payerInfo);

        $transaction = new Transaction();
        $transaction->setAmount($this->amount);

        $payment = new Payment();
        $payment->setIntent("order")
            ->setPayer($this->payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($this->redirectUrls);

        try {
            return $payment->create($this->apiContext);
        } catch (PayPalConfigurationException $ex) {
            return new Payment(null);
        }
    }
}
