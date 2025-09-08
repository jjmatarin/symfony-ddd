<?php

namespace App\Licensing\Application\Client\ChangeClientLicense;

use App\Common\Bus\CommandRequestInterface;

readonly class ChangeClientLicenseCommand implements CommandRequestInterface
{
    public function __construct(
        public mixed $id,
        public mixed $licenseType,
        public mixed $productId,
    ) {
    }
}
