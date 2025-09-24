<?php

namespace App\Management\Application\Owner\GetOwner;

use App\Shared\Bus\QueryRequestInterface;

readonly class GetOwnerQuery implements QueryRequestInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
