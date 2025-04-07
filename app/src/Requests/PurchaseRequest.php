<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;
class PurchaseRequest extends PriceCalculationRequest
{
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['paypal', 'stripe'])]
    public string $paymentProcessor;
}