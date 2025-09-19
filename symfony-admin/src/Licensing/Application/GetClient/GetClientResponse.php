<?php

namespace App\Licensing\Application\GetClient;

readonly class GetClientResponse
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
