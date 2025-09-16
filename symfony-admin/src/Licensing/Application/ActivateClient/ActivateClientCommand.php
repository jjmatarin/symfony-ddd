<?php

namespace App\Licensing\Application\ActivateClient;

readonly class ActivateClientCommand
{
    public function __construct(
        public string $id,
    ) {
    }
}
