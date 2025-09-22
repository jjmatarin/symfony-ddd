<?php

namespace App\Licensing\Application\GetClient;

class GetClientResponseProduct
{
    public function __construct(
        public string $id,
        public string $name,
        public float $price,
    ) {
    }
}
