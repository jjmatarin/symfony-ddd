<?php

namespace App\Licensing\Application\GetProduct;

readonly class GetProductResponse
{
    public function __construct(
        public string $id,
        public string $name,
        public float $price,
    ) {
    }
}
