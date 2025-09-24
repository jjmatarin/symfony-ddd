<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\DomainEventBusInterface;
use App\Common\Bus\DomainEventInterface;
use App\Common\Bus\IntegrationEventBusInterface;
use Contracts\Events\IntegrationEventInterface;
use Contracts\Stamps\TestStamp;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

class IntegrationEventBus implements IntegrationEventBusInterface
{
    public function __construct(
        private MessageBusInterface $integrationEventBus,
    ) {
    }

    public function dispatch(IntegrationEventInterface $event): void
    {
        $this->integrationEventBus->dispatch($event, [
            new TestStamp('Test Message'),
            new AmqpStamp('adminaaa.client.created')
        ]);
    }
}
