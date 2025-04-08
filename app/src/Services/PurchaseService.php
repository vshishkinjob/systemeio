<?php

namespace App\Services;

use App\Services\Payment\PaymentProcessorFactory;

class PurchaseService
{
    public function __construct(private PaymentProcessorFactory $processorFactory)
    {
    }

    public function purchase(float $price, string $paymentProcessor): bool
    {
        $processor = $this->processorFactory->create($paymentProcessor);
        return $processor->process($price);
    }
}