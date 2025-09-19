<?php

namespace App\Common\Bus;

interface DomainEventBusInterface
{
    public function dispatch(CommandRequestInterface $event): void;
}
