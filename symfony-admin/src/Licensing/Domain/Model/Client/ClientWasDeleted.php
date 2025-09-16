<?php

namespace App\Licensing\Domain\Model\Client;

readonly class ClientWasDeleted
{
    public function __construct(
        string $id,
    ) {
    }
}
