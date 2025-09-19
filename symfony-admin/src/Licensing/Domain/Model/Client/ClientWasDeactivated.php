<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\CommandRequestInterface;

readonly class ClientWasDeactivated implements CommandRequestInterface
{
    public function __construct(
        string $id,
    ) {
    }
}
