<?php

namespace App\Licensing\Application\Client\GetClient;

use App\Common\Bus\QueryResponseInterface;

readonly class GetClientResponse implements QueryResponseInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
    ) {
    }
}
