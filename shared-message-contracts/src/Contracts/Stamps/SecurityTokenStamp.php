<?php

namespace Contracts\Stamps;

use Symfony\Component\Messenger\Stamp\StampInterface;

readonly class SecurityTokenStamp implements StampInterface
{
    public function __construct(
        public string $token
    ) {
    }
}
