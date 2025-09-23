<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventBase;

readonly class ClientWasCreated extends DomainEventBase
{
    public function __construct(
        int $playhead,
        string $id,
        public string $name,
        public string $email,
        public string $description,
        public string $licenseType,
        public string $productId,
    ) {
        parent::__construct(Client::class, $id, $playhead);
    }
}
