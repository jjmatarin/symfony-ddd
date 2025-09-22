<?php

namespace App\Licensing\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Common\Domain\Model\Currency;
use App\Common\Domain\Model\EntityId;
use App\Common\Domain\Model\Money;
use App\Common\Domain\Model\Price;
use App\Licensing\Domain\Model\Product\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $id = EntityId::fromString('01K5RW4NQ6XM1NJ3CYDDTR2TKV');
        $price = new Price(new Money(20000, new Currency('EUR')), new \DateTimeImmutable());
        $product = Product::create(
            $id, 'Product 1', 'Desc product 1', $price
        );
        $manager->persist($product);

        $id = EntityId::fromString('01K5RW9AYM7V911BJM8RFCB8W3');
        $price = new Price(new Money(25000, new Currency('EUR')), new \DateTimeImmutable());
        $product = Product::create(
            $id, 'Product 2', 'Desc product 2', $price
        );
        $manager->persist($product);

        $id = EntityId::fromString('01K5RW9JHQXCSWFF917ZB6SPAC');
        $price = new Price(new Money(18000, new Currency('EUR')), new \DateTimeImmutable());
        $product = Product::create(
            $id, 'Product 3', 'Desc product 3', $price
        );
        $manager->persist($product);

        $manager->flush();
    }
}