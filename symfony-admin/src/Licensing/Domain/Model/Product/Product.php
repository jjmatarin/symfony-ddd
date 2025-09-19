<?php

namespace App\Licensing\Domain\Model\Product;

use App\Common\Domain\Model\EntityId;
use App\Common\Domain\Model\Price;

class Product
{
    private EntityId $id;
    private string $name;
    private string $description;
    private Price $price;

    public static function create(
        EntityId $id,
        string $name,
        string $description,
        Price $price
    ): self {
        return new self($id, $name, $description, $price);
    }

    private function __construct(
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