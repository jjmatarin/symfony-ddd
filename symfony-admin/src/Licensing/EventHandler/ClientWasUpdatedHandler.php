<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\DomainEventHandlerInterface;
use App\Licensing\Domain\Model\Client\ClientWasUpdated;
use App\Licensing\Infrastructure\Projector\ClientProjector;

class ClientWasUpdatedHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private ClientProjector $projector,
    ) {
    }

    public function __invoke(ClientWasUpdated $event): void
    {
        $this->projector->onClientUpdated($event);
    }
}
