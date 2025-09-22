<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\DomainEventInterface;

readonly class ClientWasUpdated implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $description
    ) {
    }
}
