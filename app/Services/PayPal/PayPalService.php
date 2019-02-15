<?php

namespace App\Services\PayPal;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

abstract class PayPalService
{
    /**
     * @var ApiContext
     */
    protected $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.client_id'),
                config('paypal.secret')
            )
        );
    }
}
