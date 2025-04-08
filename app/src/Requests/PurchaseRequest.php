<?php

namespace App\Requests;

use App\Validators\SupportedPaymentProcessor;
use Symfony\Component\Validator\Constraints as Assert;
class PurchaseRequest extends PriceCalculationRequest
{
    #[Assert\NotBlank]
    #[SupportedPaymentProcessor]
    public string $paymentProcessor;
}