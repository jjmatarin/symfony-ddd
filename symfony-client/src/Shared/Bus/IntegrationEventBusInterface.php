<?php

namespace App\Shared\Bus;

use Contracts\Integration\IntegrationEventInterface;

interface IntegrationEventBusInterface
{
    public function dispatch(IntegrationEventInterface $event): void;
}
