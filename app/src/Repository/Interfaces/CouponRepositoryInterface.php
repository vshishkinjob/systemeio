<?php

namespace App\Repository\Interfaces;

use App\Entity\Coupon;

interface CouponRepositoryInterface
{
    public function findByCode(string $code): ?Coupon;
}