<?php

namespace App\Licensing\ReadModel\Client;

class ClientDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $status,
        public string $activeLicenseType,
        public string $activeProductId
    ) {
    }
}
