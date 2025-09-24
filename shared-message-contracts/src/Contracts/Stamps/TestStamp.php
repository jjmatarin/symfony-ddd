<?php

namespace Contracts\Stamps;

use Symfony\Component\Messenger\Stamp\StampInterface;

readonly class TestStamp implements StampInterface
{
    public function __construct(
        public string $data
    ) {
    }
}
