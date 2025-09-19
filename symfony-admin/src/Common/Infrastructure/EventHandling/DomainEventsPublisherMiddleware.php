<?php

namespace App\Common\Infrastructure\EventHandling;

use App\Common\Bus\DomainEventBusInterface;
use App\Common\Domain\EventHandling\DomainEventPublisher;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\SentStamp;

class DomainEventsPublisherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private DomainEventBusInterface $domainEventBus,
    ) {

    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $sentStamp = $envelope->last(SentStamp::class);
        $envelope = $stack->next()->handle($envelope, $stack);
        if ($sentStamp == null) {
            $publisher = DomainEventPublisher::getInstance();
            foreach ($publisher->getEvents() as $event) {
                $this->domainEventBus->dispatch($event);
            }
            $publisher->reset();
        }

        return $envelope;
    }
}