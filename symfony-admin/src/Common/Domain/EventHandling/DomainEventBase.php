<?php

namespace App\Common\Domain\EventHandling;

abstract readonly class DomainEventBase implements DomainEventInterface
{
    public function __construct(
        public string $aggregateType,
        public int $playhead,
    ) {
    }
}
