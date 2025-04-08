<?php

namespace App\Repository;

use App\Entity\Coupon;
use App\Exceptions\CouponNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Repository\Interfaces\CouponRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coupon>
 */
class CouponRepository extends ServiceEntityRepository implements CouponRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function findByCode(string $code): ?Coupon
    {
        /**
         * @var Coupon $coupon
         */
        $coupon = $this->findOneBy(['code' => $code]);
        if (!$coupon) {
            throw new CouponNotFoundException();
        }
        return $coupon;
    }
}
