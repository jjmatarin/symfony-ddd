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
        $price = new Price(new Money(150, new Currency('EUR')), new \DateTimeImmutable());
        $product = new Product(
            id: EntityId::fromString('01K4MNR2BSS8RT5GHGX73WWM5E'),
            name: 'Test formative action',
            description: 'Test formative action',
            price: $price
        );
        $manager->persist($product);

        $manager->flush();
    }
}
