<?php

namespace App\Licensing\Domain\Model\Product;

use App\Common\Domain\Model\EntityId;
use App\Common\Domain\Model\Money;
use App\Common\Domain\Model\Price;

class Product
{
    private EntityId $id;
    private string $name;
    private string $description;
    private Price $price;

    public function __construct(
        EntityId $id,
        string $name,
        string $description,
        Price $price
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function changePrice(Money $money): void
    {
        $price = new Price($money, new \DateTimeImmutable());
        $this->price = $price;
    }

    public function getId(): EntityId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
