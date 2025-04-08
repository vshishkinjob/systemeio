<?php

namespace App\Tests\Unit;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Repository\Interfaces\CouponRepositoryInterface;
use App\Repository\Interfaces\ProductRepositoryInterface;
use App\Services\PriceCalculatorService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    private PriceCalculatorService $calculator;
    private MockObject $productRepository;
    private MockObject $couponRepository;

    protected function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->couponRepository = $this->createMock(CouponRepositoryInterface::class);
        $this->calculator = new PriceCalculatorService($this->productRepository, $this->couponRepository);
    }

    public function testCalculatePriceWithoutCoupon(): void
    {
        $product = new Product();
        $product->setPrice(100.00);
        $this->productRepository
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($product);
        $price = $this->calculator->calculatePrice(1, 'DE123456789');
        $this->assertEquals(119.00, $price);
    }

    public function testCalculatePriceWithPercentCoupon(): void
    {
        $product = new Product();
        $product->setPrice(100.00);
        $this->productRepository
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($product);
        $coupon = new Coupon();
        $coupon->setType('percent')->setValue(10.00);
        $this->couponRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with('D10')
            ->willReturn($coupon);
        $price = $this->calculator->calculatePrice(1, 'DE123456789', 'D10');
        $this->assertEquals(107.10, $price);
    }

    public function testCalculatePriceWithFixedCoupon(): void
    {
        $product = new Product();
        $product->setPrice(100.00);
        $this->productRepository
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($product);
        $coupon = new Coupon();
        $coupon->setType('fixed')->setValue(20.00);
        $this->couponRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with('F20')
            ->willReturn($coupon);
        $price = $this->calculator->calculatePrice(1, 'DE123456789', 'F20');
        $this->assertEquals(95.20, $price);
    }

    public function testCalculatePriceWithInvalidCountryCode(): void
    {
        $product = new Product();
        $product->setPrice(100.00);
        $this->productRepository
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($product);
        $price = $this->calculator->calculatePrice(1, 'XX123456789');
        $this->assertEquals(100.00, $price);
    }
}