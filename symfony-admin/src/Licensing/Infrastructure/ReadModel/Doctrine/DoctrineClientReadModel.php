<?php

namespace App\Licensing\Infrastructure\ReadModel\Doctrine;

use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientStatusEnum;
use App\Licensing\ReadModel\Client\ClientDTO;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineClientReadModel extends EntityRepository implements ClientReadModelInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $metadata = $registry->getManager('read_model')->getClassMetadata(Client::class);
        parent::__construct($registry->getManager('read_model'), $metadata);
    }

    public function listAll(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.status != :status')
            ->setParameter('status', ClientStatusEnum::DELETED)
        ;
        $result = [];
        /** @var Client $client */
        foreach ($qb->getQuery()->getResult() as $client) {
            $result[] = new ClientDTO(
                $client->getId()->get(),
                $client->getName(),
                $client->getEmail(),
                $client->getStatus()->value,
                $client->getActiveLicenseType()->value,
                $client->getActiveLicenseProductId()->get()
            );
        };
        return $result;
    }

    public function getById(string $id): ?ClientDTO
    {
        $client = $this->find($id);
        if (null === $client) {
            return null;
        }
        return new ClientDTO(
            $client->getId()->get(),
            $client->getName(),
            $client->getEmail(),
            $client->getStatus()->value,
            $client->getActiveLicenseType()->value,
            $client->getActiveLicenseProductId()->get()
        );
    }
}
