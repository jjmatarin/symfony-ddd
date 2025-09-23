<?php

namespace App\Common\Infrastructure\EventHandling;

use App\Common\Domain\EventHandling\DomainEventPublisher;
use App\Common\Infrastructure\EventStore\Doctrine\EventStore;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\SentStamp;

class DomainEventsPersisterMiddleware implements MiddlewareInterface
{
    public function __construct(
        private EventStore $eventStore,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $sentStamp = $envelope->last(SentStamp::class);
        $envelope = $stack->next()->handle($envelope, $stack);
        if ($sentStamp == null) {
            $publisher = DomainEventPublisher::getInstance();
            foreach ($publisher->getEvents() as $event) {
                $this->eventStore->append($event);
            }
        }

        return $envelope;
    }
}