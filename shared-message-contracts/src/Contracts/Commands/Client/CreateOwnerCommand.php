<?php

namespace Contracts\Commands\Client;

class CreateOwnerCommand
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
    ) {
    }
}
