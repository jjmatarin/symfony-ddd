<?php

namespace App\Common\Bus;

interface DomainEventBusInterface
{
    public function dispatch(DomainEventInterface $event): void;
}
