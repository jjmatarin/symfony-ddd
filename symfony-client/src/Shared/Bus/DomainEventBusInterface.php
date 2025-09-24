<?php

namespace App\Shared\Bus;

interface DomainEventBusInterface
{
    public function dispatch(DomainEventInterface $event): void;
}
