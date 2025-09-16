<?php

namespace App\Licensing\Application\ChangeClientLicense;

readonly class ChangeClientLicenseCommand
{
    public function __construct(
        public string $id,
        public string $licenseType,
        public string $productId,
    ) {
    }
}
