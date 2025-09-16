<?php

namespace App\Licensing\Application\UpdateClient;

readonly class UpdateClientCommand
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $description,
    ) {
    }
}
