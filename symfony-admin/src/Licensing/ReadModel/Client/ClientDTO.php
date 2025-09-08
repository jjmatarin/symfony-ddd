<?php

namespace App\Licensing\ReadModel\Client;

use App\Common\Bus\QueryResponseInterface;

readonly class ClientDTO implements QueryResponseInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description = null,
        public ?string $licenseType = null,
    ) {
    }
}
