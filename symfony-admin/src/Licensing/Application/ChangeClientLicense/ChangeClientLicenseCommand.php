<?php

namespace App\Licensing\Application\ChangeClientLicense;

use App\Common\Bus\CommandRequestInterface;

readonly class ChangeClientLicenseCommand implements CommandRequestInterface
{
    public function __construct(
        public string $id,
        public string $licenseType,
        public string $productId,
    ) {
    }
}
