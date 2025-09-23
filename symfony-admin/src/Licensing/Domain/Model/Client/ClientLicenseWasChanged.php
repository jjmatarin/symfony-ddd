<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventBase;

readonly class ClientLicenseWasChanged extends DomainEventBase
{
    public function __construct(
        int $playhead,
        string $id,
        public string $licenseType,
        public string $productId,
    ) {
        parent::__construct(Client::class, $id, $playhead);
    }
}
