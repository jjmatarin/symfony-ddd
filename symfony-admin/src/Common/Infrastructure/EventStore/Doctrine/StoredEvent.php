<?php

namespace App\Common\Infrastructure\EventStore\Doctrine;

class StoredEvent
{
    private string $aggregateId;
    private string $aggregateType;
    private int $playhead;
    private string $eventType;
    private array $payload;
    private \DateTimeImmutable $recordedAt;

    public function __construct(
        string $aggregateId,
        string $aggregateType,
        int $playhead,
        string $eventType,
        array $payload
    ) {
        $this->aggregateId = $aggregateId;
        $this->aggregateType = $aggregateType;
        $this->playhead = $playhead;
        $this->eventType = $eventType;
        $this->payload = $payload;
        $this->recordedAt = new \DateTimeImmutable();
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getAggregateType(): string
    {
        return $this->aggregateType;
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getRecordedAt(): \DateTimeImmutable
    {
        return $this->recordedAt;
    }
}