<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\EventHandlerInterface;
use App\Licensing\Domain\Model\Client\ClientWasDeleted;
use App\Licensing\Projection\ClientProjector;

readonly class ClientWasDeletedHandler implements EventHandlerInterface
{
    public function __construct(
        private ClientProjector $clientProjector
    ) {
    }

    public function __invoke(ClientWasDeleted $event): void
    {
        $this->projectReadModel($event);
    }

    private function projectReadModel(ClientWasDeleted $event): void
    {
        $this->clientProjector->onClientDeleted($event);
    }
}
