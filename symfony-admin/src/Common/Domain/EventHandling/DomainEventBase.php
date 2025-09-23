<?php

namespace App\Common\Domain\EventHandling;

use App\Common\Bus\DomainEventInterface;

readonly abstract class DomainEventBase implements DomainEventInterface
{
    public function __construct(
        public string $aggregateType,
        public string $id,
        public int $playhead
    ) {
    }
}