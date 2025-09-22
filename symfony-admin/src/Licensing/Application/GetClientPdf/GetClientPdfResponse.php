<?php

namespace App\Licensing\Application\GetClientPdf;

readonly class GetClientPdfResponse
{
    public function __construct(
        public string $filename,
        public string $data,
    ) {
    }
}
