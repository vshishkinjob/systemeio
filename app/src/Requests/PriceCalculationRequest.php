<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;
class PriceCalculationRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public int $product;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^(DE[0-9]{9}|IT[0-9]{11}|GR[0-9]{9}|FR[A-Z]{2}[0-9]{9})$/",
        message: "Invalid tax number format"
    )]
    public string $taxNumber;

    #[Assert\Type('string')]
    public ?string $couponCode = null;
}