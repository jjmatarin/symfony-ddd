<?php

namespace App\Licensing\Application\Client\UpdateClient;

use App\Common\Bus\CommandRequestInterface;

readonly class UpdateClientCommand implements CommandRequestInterface
{
    public function __construct(
        public mixed $id,
        public mixed $name,
        public mixed $description
    ) {
    }
}
