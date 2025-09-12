<?php

namespace App\Common\Infrastructure\EventHandling\Symfony;

use App\Common\Bus\DomainEventBusInterface;
use App\Common\Domain\EventHandling\DomainEventPublisher;
use App\Common\Infrastructure\EventStore\Doctrine\EventStore;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

readonly class DomainEventsPublisherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private DomainEventBusInterface $bus,
        private EventStore $eventStore,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $received = count($envelope->all(ReceivedStamp::class)) == 0;

        $envelope = $stack->next()->handle($envelope, $stack);

        if ($received) {
            $publisher = DomainEventPublisher::getInstance();
            foreach ($publisher->getEvents() as $event) {
                $this->eventStore->append($event);
                $this->bus->dispatch($event);
            }
            $publisher->reset();
        }

        return $envelope;
    }
}
