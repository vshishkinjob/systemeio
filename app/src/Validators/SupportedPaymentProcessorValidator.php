<?php

namespace App\Validators;

use App\Services\Payment\PaymentProcessorFactory;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SupportedPaymentProcessorValidator extends ConstraintValidator
{
    public function __construct(private PaymentProcessorFactory $processorFactory)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof SupportedPaymentProcessor) {
            throw new UnexpectedTypeException($constraint, SupportedPaymentProcessor::class);
        }
        if ($value === null || $value === '') {
            return;
        }
        $supportedProcessors = $this->processorFactory->getSupportedProcessors();
        if (!in_array($value, $supportedProcessors, true)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ supported }}', implode(', ', $supportedProcessors))
                ->addViolation();
        }
    }
}