<?php

namespace App\Common\Domain\EventHandling;

class DomainEventPublisher
{
    private static ?DomainEventPublisher $instance = null;

    private array $events = [];

    public static function getInstance(): DomainEventPublisher
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __clone(): void
    {
        throw new \BadMethodCallException('Cloning is not allowed.');
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
