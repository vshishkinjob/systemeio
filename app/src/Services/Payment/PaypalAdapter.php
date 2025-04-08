<?php

namespace App\Services\Payment;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalAdapter implements PaymentProcessorInterface
{
    public function __construct(private PaypalPaymentProcessor $processor)
    {
    }

    public function process(float $amount): bool
    {
        try {
            $this->processor->pay(intval($amount));
            return true;
        } catch (\Exception $exception) {
            // Логика если платеж не удался
            return false;
        }
    }
}