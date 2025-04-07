<?php

namespace App\Services;

use App\Entity\Coupon;
use App\Entity\Product;

class PriceCalculator
{
    private array $taxRates = [
        'DE' => 0.19,
        'IT' => 0.22,
        'FR' => 0.20,
        'GR' => 0.24,
    ];

    public function calculatePrice(Product $product, string $taxNumber, ?Coupon $coupon = null): float
    {
        $basePrice = $product->getPrice();
        if ($coupon) {
            $basePrice = $this->applyCoupon($basePrice, $coupon);
        }
        $countryCode = substr($taxNumber, 0, 2);
        $taxRate = $this->taxRates[$countryCode] ?? 0;
        return round($basePrice * (1 + $taxRate), 2);
    }

    private function applyCoupon(float $price, Coupon $coupon): float
    {
        if ($coupon->getType() === 'percent') {
            return $price * (1 - $coupon->getValue() / 100);
        }
        return max(0, $price - $coupon->getValue());
    }
}