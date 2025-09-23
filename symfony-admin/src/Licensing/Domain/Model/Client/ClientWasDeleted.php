<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventBase;

readonly class ClientWasDeleted extends DomainEventBase
{
    public function __construct(
        int $playhead,
        string $id,
    ) {
        parent::__construct(Client::class, $id, $playhead);
    }
}
