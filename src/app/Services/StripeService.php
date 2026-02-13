<?php

namespace App\Services;

use Stripe\Checkout\Session;

class StripeService
{
    public function createSession(array $params)
    {
        return Session::create($params);
    }
}
