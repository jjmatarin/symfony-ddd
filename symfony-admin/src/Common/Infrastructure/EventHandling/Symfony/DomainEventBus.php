<?php

namespace App\Common\Infrastructure\EventHandling\Symfony;

use App\Common\Bus\DomainEventBusInterface;
use App\Common\Domain\EventHandling\DomainEventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class DomainEventBus implements DomainEventBusInterface
{
    public function __construct(
        private MessageBusInterface $domainEventBus,
    ) {
    }

    public function dispatch(DomainEventInterface $event): void
    {
        $this->domainEventBus->dispatch($event);
    }
}
