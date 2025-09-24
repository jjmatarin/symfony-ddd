<?php

namespace App\Shared\Infrastructure\EventHandling;

use App\Shared\Bus\DomainEventBusInterface;
use App\Shared\EventHandling\DomainEventPublisher;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\SentStamp;

readonly class DomainEventsPublisherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private DomainEventBusInterface $bus,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $sentStamp = $envelope->last(SentStamp::class);
        $envelope = $stack->next()->handle($envelope, $stack);
        if ($sentStamp == null) {
            $publisher = DomainEventPublisher::getInstance();
            foreach ($publisher->getEvents() as $event) {
                $this->bus->dispatch($event);
            }
            $publisher->reset();
        }

        return $envelope;
    }
}
