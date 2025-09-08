<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\EventHandlerInterface;
use App\Licensing\Domain\Model\Client\ClientWasUpdated;
use App\Licensing\Projection\ClientProjector;

class ClientWasUpdatedHandler implements EventHandlerInterface
{
    public function __construct(
        private readonly ClientProjector $clientProjector
    ) {
    }

    public function __invoke(ClientWasUpdated $event): void
    {
        $this->projectReadModel($event);
    }

    private function projectReadModel(ClientWasUpdated $event): void
    {
        $this->clientProjector->onClientUpdated($event);
    }

}
