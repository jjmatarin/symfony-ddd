<?php

namespace App\Common\Infrastructure\EventHandling\Symfony;

use App\Common\Bus\DomainEventBusInterface;
use App\Common\Domain\EventHandling\DomainEventPublisher;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

readonly class DomainEventsPublisherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private DomainEventBusInterface $bus
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        $publisher = DomainEventPublisher::getInstance();
        foreach ($publisher->getEvents() as $event) {
            $this->bus->dispatch($event);
        }
        $publisher->reset();
        return $envelope;
    }
}
