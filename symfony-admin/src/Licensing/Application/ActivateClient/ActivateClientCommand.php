<?php

namespace App\Licensing\Application\ActivateClient;

use App\Common\Bus\CommandRequestInterface;

readonly class ActivateClientCommand implements CommandRequestInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
