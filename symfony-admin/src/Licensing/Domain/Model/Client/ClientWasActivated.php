<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\DomainEventInterface;

readonly class ClientWasActivated implements DomainEventInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
