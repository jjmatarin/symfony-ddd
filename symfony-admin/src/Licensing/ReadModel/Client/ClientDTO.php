<?php

namespace App\Licensing\ReadModel\Client;

use App\Licensing\ReadModel\Product\ProductDTO;

class ClientDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $activeLicenseType,
        public ProductDTO $activeProduct,
    ) {
    }
}
