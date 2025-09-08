<?php

namespace App\Licensing\Application\Client\GetClient;

use App\Common\Bus\QueryRequestInterface;

readonly class GetClientCommand implements QueryRequestInterface
{
    public function __construct(
        public mixed $id,
    ) {
    }
}
