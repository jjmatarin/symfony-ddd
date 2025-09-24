<?php

namespace App\Common\Bus;

use Contracts\Events\IntegrationEventInterface;

interface IntegrationEventBusInterface
{
    public function dispatch(IntegrationEventInterface $event): void;
}
