<?php

namespace App\Licensing\Application\Client\CreateClient;

use App\Common\Bus\CommandResponseInterface;

class CreateClientResponse implements CommandResponseInterface
{
    public function __construct(
        public string $id
    ) {
    }
}
