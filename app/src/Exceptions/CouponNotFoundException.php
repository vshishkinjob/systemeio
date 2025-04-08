<?php

namespace App\Exceptions;

class CouponNotFoundException extends BaseHttpException
{
    public function __construct(string $message = 'Invalid coupon code')
    {
        parent::__construct($message, 404);
    }
}