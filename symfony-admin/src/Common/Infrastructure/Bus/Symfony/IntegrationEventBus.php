<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\DomainEventBusInterface;
use App\Common\Bus\DomainEventInterface;
use App\Common\Bus\IntegrationEventBusInterface;
use Contracts\Events\IntegrationEventInterface;
use Contracts\Stamps\TestStamp;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class IntegrationEventBus implements IntegrationEventBusInterface
{
    public function __construct(
        private MessageBusInterface $integrationEventBus,
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    public function dispatch(IntegrationEventInterface $event): void
    {
        $token = $this->tokenStorage->getToken();
        $jwtToken = $token->getUser()->token;

        $this->integrationEventBus->dispatch($event, [
            new TestStamp('Test Message'),
#            new AmqpStamp('admin.client.created')
        ]);
    }
}
