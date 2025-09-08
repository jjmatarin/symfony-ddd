<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventInterface;

class ClientWasUpdated implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description
    ) {
    }

}
