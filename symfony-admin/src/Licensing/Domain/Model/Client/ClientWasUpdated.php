<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\CommandRequestInterface;

readonly class ClientWasUpdated implements CommandRequestInterface
{
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $description
    ) {
    }
}
