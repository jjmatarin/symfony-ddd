<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\EventHandlerInterface;
use App\Licensing\Domain\Model\Client\ClientWasCreated;
use App\Licensing\Projection\ClientProjector;

readonly class ClientWasCreatedHandler implements EventHandlerInterface
{
    public function __construct(
        private ClientProjector $clientProjector
    ) {
    }

    public function __invoke(ClientWasCreated $event): void
    {
        $this->projectReadModel($event);
    }

    private function projectReadModel(ClientWasCreated $event): void
    {
        $this->clientProjector->onClientCreated($event);
    }

}
