<?php

namespace App\Licensing\ReadModel\Product;

class ProductDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public float $price
    ) {
    }
}
