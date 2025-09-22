<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Bus\DomainEventInterface;

readonly class ClientLicenseWasChanged implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public string $licenseType,
        public string $productId,
    ) {
    }
}
