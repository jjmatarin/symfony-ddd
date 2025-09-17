<?php

namespace App\Licensing\Application\GetClient;

use App\Common\Bus\QueryRequestInterface;

readonly class GetClientQuery implements QueryRequestInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
