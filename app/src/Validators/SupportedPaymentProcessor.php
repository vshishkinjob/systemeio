<?php

namespace App\Validators;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class SupportedPaymentProcessor extends Constraint
{
    public string $message = 'The payment processor "{{ value }}" is not supported. Supported processors: {{ supported }}.';
}