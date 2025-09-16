<?php

namespace App\Licensing\Domain\Model\Client;

readonly class ClientLicenseWasChanged
{
    public function __construct(
        string $id,
        string $licenseType,
        string $productId,
    ) {
    }
}
