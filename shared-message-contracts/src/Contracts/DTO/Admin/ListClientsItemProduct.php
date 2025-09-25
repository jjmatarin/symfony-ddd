<?php

namespace Contracts\DTO\Admin;

class ListClientsItemProduct
{
    public function __construct(
        public string $id,
        public string $name,
        public float $price,
    ) {
    }
}
