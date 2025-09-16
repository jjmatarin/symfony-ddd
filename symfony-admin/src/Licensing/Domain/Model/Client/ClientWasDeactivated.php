<?php

namespace App\Licensing\Domain\Model\Client;

readonly class ClientWasDeactivated
{
    public function __construct(
        string $id,
    ) {
    }
}
