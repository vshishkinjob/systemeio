<?php

namespace App\Services\Payment;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripeAdapter implements PaymentProcessorInterface
{
    public function __construct(private StripePaymentProcessor $processor)
    {
    }

    public function process(float $amount): bool
    {
        return $this->processor->processPayment($amount);
    }
}