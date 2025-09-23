<?php

namespace App\Common\Domain\Model;

use App\Common\Bus\DomainEventInterface;
use App\Common\Domain\EventHandling\DomainEventBase;
use App\Common\Domain\EventHandling\DomainEventPublisher;

trait AggregateEventsTrait
{
    private int $playhead = 0;

    public static function hydrateFromEvents(array $events): self
    {
        $self = new self();
        foreach ($events as $event) {
            $self->apply($event);
        }
        return $self;
    }

    private function applyEvent(DomainEventInterface $event): void
    {
        DomainEventPublisher::getInstance()->publish($event);
        $this->apply($event);
    }

    private function apply(DomainEventBase $event): void
    {
        $this->playhead = $event->playhead;
        $eventName = (new \ReflectionClass($event))->getShortName();
        $handler = 'apply' . $eventName;
        if (method_exists($this, $handler)) {
            $this->$handler($event);
        }
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }
}