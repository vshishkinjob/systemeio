<?php

namespace App\Services;

use App\Entity\Coupon;
use App\Repository\Interfaces\CouponRepositoryInterface;
use App\Repository\Interfaces\ProductRepositoryInterface;

class PriceCalculatorService
{
    private array $taxRates = [
        'DE' => 0.19,
        'IT' => 0.22,
        'FR' => 0.20,
        'GR' => 0.24,
    ];

    public function __construct(private ProductRepositoryInterface $productRepository, private CouponRepositoryInterface $couponRepository)
    {
    }

    public function calculatePrice(int $productId, string $taxNumber, ?string $couponCode = null): float
    {
        $product = $this->productRepository->findById($productId);
        $basePrice = $product->getPrice();
        if ($couponCode) {
            $coupon = $this->couponRepository->findByCode($couponCode);
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