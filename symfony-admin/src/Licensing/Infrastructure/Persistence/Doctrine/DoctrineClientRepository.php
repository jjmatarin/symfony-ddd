<?php

namespace App\Licensing\Infrastructure\Persistence\Doctrine;

use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;
use App\Licensing\Domain\Model\Client\ClientStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function getById(EntityId $id): ?Client
    {
        return $this->find($id);
    }

    public function persist(Client $client): void
    {
        $this->getEntityManager()->persist($client);
        $this->getEntityManager()->flush();
    }

    public function listAll(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.status != :status')
            ->setParameter('status', ClientStatusEnum::DELETED)
        ;
        return $qb->getQuery()->getResult();
    }


}