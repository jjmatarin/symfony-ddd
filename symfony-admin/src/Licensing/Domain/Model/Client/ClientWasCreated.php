<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\EventHandling\DomainEventInterface;

readonly class ClientWasCreated implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $licenseType,
        public string $productId
    ) {
    }
}
