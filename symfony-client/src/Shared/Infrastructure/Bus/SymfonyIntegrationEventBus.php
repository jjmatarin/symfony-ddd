<?php

namespace App\Shared\Infrastructure\Bus;

use App\Common\Bus\IntegrationEventBusInterface;
use Contracts\Integration\IntegrationEventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyIntegrationEventBus implements IntegrationEventBusInterface
{
    public function __construct(
        private MessageBusInterface $integrationEventBus,
    ) {
    }

    public function dispatch(IntegrationEventInterface $event): void
    {
        $this->integrationEventBus->dispatch($event);
    }
}
