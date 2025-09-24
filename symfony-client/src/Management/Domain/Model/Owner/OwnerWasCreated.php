<?php

namespace App\Management\Domain\Model\Owner;

use App\Shared\Bus\DomainEventInterface;

readonly class OwnerWasCreated implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
    ) {
    }
}
