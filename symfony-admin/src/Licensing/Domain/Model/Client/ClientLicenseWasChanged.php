<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\CommandRequestInterface;

readonly class ClientLicenseWasChanged implements CommandRequestInterface
{
    public function __construct(
        string $id,
        string $licenseType,
        string $productId,
    ) {
    }
}
