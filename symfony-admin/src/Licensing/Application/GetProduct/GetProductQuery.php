<?php

namespace App\Licensing\Application\GetProduct;

use App\Common\Bus\QueryRequestInterface;

readonly class GetProductQuery implements QueryRequestInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
