<?php

namespace App\Common\Domain\EventHandling;

class DomainEventPublisher
{
    private static ?DomainEventPublisher $instance = null;

    private array $events = [];

    public static function getInstance(): self
    {
        if (static::$instance == null) {
            static::$instance = new DomainEventPublisher();
        }
        return static::$instance;
    }

    public function publish($event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function reset(): void
    {
        $this->events = [];
    }
}