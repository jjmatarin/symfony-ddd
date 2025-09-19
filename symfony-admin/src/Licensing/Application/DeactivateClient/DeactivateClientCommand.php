<?php

namespace App\Licensing\Application\DeactivateClient;

use App\Common\Bus\CommandRequestInterface;

readonly class DeactivateClientCommand implements CommandRequestInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
