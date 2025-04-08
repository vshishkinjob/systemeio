<?php

namespace App\Repository\Interfaces;

use App\Entity\Product;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;
}