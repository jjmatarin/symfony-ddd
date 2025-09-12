<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventBase;

readonly class LicenseWasChanged extends DomainEventBase
{
    public function __construct(
        int $playhead,
        public string $id,
        public string $licenseType,
        public string $productId,
    ) {
        parent::__construct(Client::class, $playhead);
    }
}
