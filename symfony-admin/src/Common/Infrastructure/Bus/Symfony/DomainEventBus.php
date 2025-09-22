<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\DomainEventBusInterface;
use App\Common\Bus\DomainEventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DomainEventBus implements DomainEventBusInterface
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