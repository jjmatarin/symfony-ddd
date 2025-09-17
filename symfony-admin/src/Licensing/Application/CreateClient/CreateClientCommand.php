<?php

namespace App\Licensing\Application\CreateClient;

use App\Common\Bus\CommandRequestInterface;

readonly class CreateClientCommand implements CommandRequestInterface
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
