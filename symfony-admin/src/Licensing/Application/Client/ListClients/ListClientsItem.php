<?php

namespace App\Licensing\Application\Client\ListClients;

use App\Common\Bus\CommandResponseInterface;

readonly class ListClientsItem implements CommandResponseInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
    ) {
    }
}
