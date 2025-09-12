<?php

namespace App\Licensing\Infrastructure\Persistence\Doctrine\Model\Client;

use App\Common\Domain\Model\EntityId;
use App\Common\Infrastructure\EventStore\Doctrine\EventStore;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineClientEventStoreRepository implements ClientRepository
{
    public function __construct(
        private EventStore $eventStore,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function getById(EntityId $id): ?Client
    {
        return $this->eventStore->getById(Client::class, $id);
    }

    public function persist(Client $client): void
    {
        $this->entityManager->persist($client);
    }
}
