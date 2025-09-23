<?php

namespace App\Common\Infrastructure\EventStore\Doctrine;

class Snapshot
{
    private string $aggregateId;
    private string $aggregateType;
    private int $lastPlayhead;
    private array $payload;
    private \DateTimeImmutable $recordedAt;

    public static function create(
        string $aggregateId,
        string $aggregateType,
        int $lastPlayhead,
        array $payload,
    ) {
        return new self($aggregateId, $aggregateType, $lastPlayhead, $payload);
    }

    private function __construct(
        string $aggregateId,
        string $aggregateType,
        int $lastPlayhead,
        array $payload,
    ) {
        $this->aggregateId = $aggregateId;
        $this->aggregateType = $aggregateType;
        $this->lastPlayhead = $lastPlayhead;
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

    public function getLastPlayhead(): int
    {
        return $this->lastPlayhead;
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