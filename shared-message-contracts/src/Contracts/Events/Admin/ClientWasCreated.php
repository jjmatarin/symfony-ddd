<?php

namespace Contracts\Events\Admin;

use Contracts\Events\IntegrationEventInterface;

class ClientWasCreated implements IntegrationEventInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
    ) {
    }
}
