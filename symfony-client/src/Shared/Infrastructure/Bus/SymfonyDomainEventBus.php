<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Bus\DomainEventBusInterface;
use App\Shared\Bus\DomainEventInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyDomainEventBus implements DomainEventBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $domainEventBus,
    )
    {
        $this->messageBus = $domainEventBus;
    }

    public function dispatch(DomainEventInterface $event): void
    {
        $this->messageBus->dispatch($event);
    }
}
