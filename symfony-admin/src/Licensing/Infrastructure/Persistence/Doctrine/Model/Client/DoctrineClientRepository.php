<?php

namespace App\Licensing\Infrastructure\Persistence\Doctrine\Model\Client;

use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineClientRepository extends ServiceEntityRepository implements ClientRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function getById(EntityId $id): ?Client
    {
        return $this->find($id);
    }

    public function listAll(): array
    {
        return $this->findAll();
    }

    public function persist(Client $client): void
    {
        $this->getEntityManager()->persist($client);
    }
}
