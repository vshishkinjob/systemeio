<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Продукты
        $iphone = new Product();
        $iphone->setName('Iphone')->setPrice(100.00);
        $manager->persist($iphone);

        $headphones = new Product();
        $headphones->setName('Наушники')->setPrice(20.00);
        $manager->persist($headphones);

        $case = new Product();
        $case->setName('Чехол')->setPrice(10.00);
        $manager->persist($case);

        // Купоны
        $couponD15 = new Coupon();
        $couponD15->setCode('D15')->setType('percent')->setValue(15.00);
        $manager->persist($couponD15);

        $couponP10 = new Coupon();
        $couponP10->setCode('P10')->setType('percent')->setValue(10.00);
        $manager->persist($couponP10);

        $couponF5 = new Coupon();
        $couponF5->setCode('F5')->setType('fixed')->setValue(5.00);
        $manager->persist($couponF5);

        $manager->flush();
    }
}
