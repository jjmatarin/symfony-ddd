<?php

namespace App\Management\Application\Owner\CreateOwner;

use App\Shared\Bus\CommandRequestInterface;

readonly class CreateOwnerCommand implements CommandRequestInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
    ) {
    }
}
