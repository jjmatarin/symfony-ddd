<?php

namespace App\Licensing\Application\DeleteClient;

readonly class DeleteClientCommand
{
    public function __construct(
        public string $id,
    ) {
    }
}
