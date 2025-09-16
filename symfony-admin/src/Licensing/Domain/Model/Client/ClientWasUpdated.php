<?php

namespace App\Licensing\Domain\Model\Client;

readonly class ClientWasUpdated
{
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $description
    ) {
    }
}
