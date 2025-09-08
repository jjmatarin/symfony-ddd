<?php

namespace App\Licensing\Application\Client\DeleteClient;

use App\Common\Bus\CommandRequestInterface;

readonly class DeleteClientCommand implements CommandRequestInterface
{
    public function __construct(
        public mixed $id,
    ) {
    }
}
