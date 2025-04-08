<?php

namespace App\Services\Payment;

interface PaymentProcessorInterface
{
    public function process(float $amount): bool;
}