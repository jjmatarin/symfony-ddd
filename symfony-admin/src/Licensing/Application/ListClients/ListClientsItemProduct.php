<?php

namespace App\Licensing\Application\ListClients;

class ListClientsItemProduct
{
    public function __construct(
        public string $id,
        public string $name,
        public float $price,
    ) {
    }
}
