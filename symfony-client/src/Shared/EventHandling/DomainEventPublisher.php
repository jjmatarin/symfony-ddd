<?php

namespace App\Shared\EventHandling;

use App\Shared\Bus\DomainEventInterface;

class DomainEventPublisher
{
    private static ?DomainEventPublisher $instance = null;

    private array $events = [];

    public static function getInstance(): self
    {
        if (static::$instance == null) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    public function publish(DomainEventInterface $event): void
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
