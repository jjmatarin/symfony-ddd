<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\DomainEventHandlerInterface;
use App\Licensing\Domain\Model\Client\ClientWasDeleted;
use App\Licensing\Domain\Model\Client\ClientWasUpdated;
use App\Licensing\Infrastructure\Projector\ClientProjector;

class ClientWasDeletedHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private ClientProjector $projector,
    ) {
    }

    public function __invoke(ClientWasDeleted $event): void
    {
        $this->projector->onClientDeleted($event);
    }
}
