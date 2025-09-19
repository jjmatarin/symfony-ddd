<?php

namespace App\Licensing\Application\UpdateClient;

use App\Common\Bus\CommandRequestInterface;

readonly class UpdateClientCommand implements CommandRequestInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $description,
    ) {
    }
}
