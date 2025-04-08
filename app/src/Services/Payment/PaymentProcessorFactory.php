<?php

namespace App\Services\Payment;

class PaymentProcessorFactory
{
    public function __construct(private array $processors)
    {
    }

    public function create(string $processorName): PaymentProcessorInterface
    {
        if (!isset($this->processors[$processorName])) {
            throw new \InvalidArgumentException(sprintf('Payment processor "%s" is not supported.', $processorName));
        }
        if (!$this->processors[$processorName] instanceof PaymentProcessorInterface) {
            throw new \LogicException(sprintf('Service "%s" must implement PaymentProcessorInterface.', $processorName));
        }
        return $this->processors[$processorName];
    }

    public function getSupportedProcessors(): array
    {
        return array_keys($this->processors);
    }
}