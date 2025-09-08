<?php

namespace App\Licensing\Application\Client\CreateClient;

use App\Common\Bus\CommandRequestInterface;

readonly class CreateClientCommand implements CommandRequestInterface
{
    public function __construct(
        public mixed $name,
        public mixed $description,
        public mixed $licenseType,
        public mixed $productId
    ) {
    }
}
