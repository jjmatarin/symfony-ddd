<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\CommandRequestInterface;
use App\Common\Bus\DomainEventBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DomainEventBus implements DomainEventBusInterface
{
    public function __construct(
        private MessageBusInterface $domainEventBus,
    ) {
    }

    public function dispatch(CommandRequestInterface $event): void
    {
        $this->domainEventBus->dispatch($event);
    }
}