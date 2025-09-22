<?php

namespace App\Licensing\Application\GetClientPdf;

use App\Common\Bus\QueryRequestInterface;

readonly class GetClientPdfQuery implements QueryRequestInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
