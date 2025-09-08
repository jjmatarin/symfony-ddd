<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventInterface;

class LicenseWasChanged implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public string $licenseType,
        public string $productId,
    ) {
    }
}
