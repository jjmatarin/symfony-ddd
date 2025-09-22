<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\DomainEventInterface;

readonly class ClientWasDeleted implements DomainEventInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
