<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventInterface;

class ClientWasDeleted implements DomainEventInterface
{
    public function __construct(
        public string $id,
    ) {
    }

}
