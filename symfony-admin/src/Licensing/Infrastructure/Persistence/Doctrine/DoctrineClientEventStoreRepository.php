<?php

namespace App\Licensing\Infrastructure\Persistence\Doctrine;

use App\Common\Domain\Model\EntityId;
use App\Common\Infrastructure\EventStore\Doctrine\EventStore;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

class DoctrineClientEventStoreRepository implements ClientRepositoryInterface
{
    public function __construct(
        private EventStore $eventStore
    ) {
    }

    public function getById(EntityId $id): ?Client
    {
        return $this->eventStore->getById(Client::class, $id);
    }

    public function persist(Client $client): void
    {
    }
}