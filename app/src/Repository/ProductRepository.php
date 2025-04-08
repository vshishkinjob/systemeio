<?php

namespace App\Repository;

use App\Entity\Product;
use App\Exceptions\ProductNotFoundException;
use App\Repository\Interfaces\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findById(int $id): Product
    {
        $product = $this->find($id);
        if (!$product) {
            throw new ProductNotFoundException();
        }
        return $product;
    }
}
