<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\CommandRequestInterface;

readonly class ClientWasDeleted implements CommandRequestInterface
{
    public function __construct(
        string $id,
    ) {
    }
}
