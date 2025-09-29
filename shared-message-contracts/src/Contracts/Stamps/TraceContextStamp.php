<?php

namespace Contracts\Stamps;

use Symfony\Component\Messenger\Stamp\StampInterface;

readonly class TraceContextStamp implements StampInterface
{
    public function __construct(
        public array $traceHeaders
    ) {
    }
}
