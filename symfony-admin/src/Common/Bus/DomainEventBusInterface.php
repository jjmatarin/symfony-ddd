<?php

namespace App\Common\Bus;

use App\Common\Domain\EventHandling\DomainEventInterface;

interface DomainEventBusInterface
{
    public function dispatch(DomainEventInterface $event): void;
}
