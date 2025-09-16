<?php

namespace App\Licensing\Application\CreateClient;

readonly class CreateClientCommand
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $description,
        public string $licenseType,
        public string $productId,
    ) {
    }
}
