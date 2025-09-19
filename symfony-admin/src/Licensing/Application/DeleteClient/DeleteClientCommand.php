<?php

namespace App\Licensing\Application\DeleteClient;

use App\Common\Bus\CommandRequestInterface;

readonly class DeleteClientCommand implements CommandRequestInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
