<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\DomainEventHandlerInterface;
use App\Common\Bus\IntegrationEventBusInterface;
use App\Licensing\Domain\Model\Client\ClientWasCreated;
use App\Licensing\Infrastructure\Projector\ClientProjector;

class ClientWasCreatedHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private ClientProjector $projector,
        private ClientWasCreatedTransformer $transformer,
        private IntegrationEventBusInterface $integrationEventBus
    ) {
    }

    public function __invoke(ClientWasCreated $event): void
    {
        $this->projector->onClientCreated($event);
        $this->integrationEventBus->dispatch($this->transformer->__invoke($event));
    }
}
