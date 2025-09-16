<?php

namespace App\Licensing\Application\DeactivateClient;

readonly class DeactivateClientCommand
{
    public function __construct(
        public string $id,
    ) {
    }
}
