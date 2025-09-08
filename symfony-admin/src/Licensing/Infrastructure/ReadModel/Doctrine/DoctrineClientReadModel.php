<?php

namespace App\Licensing\Infrastructure\ReadModel\Doctrine;

use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\ReadModel\Client\ClientDTO;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineClientReadModel extends EntityRepository implements ClientReadModelInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $metadata = $registry->getManager('readmodel')->getClassMetadata(Client::class);
        parent::__construct($registry->getManager('readmodel'), $metadata);
    }

    public function create(ClientDTO $clientDTO): void
    {
        // TODO: Implement create() method.
    }

    public function update(ClientDTO $clientDTO): void
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }

    public function listAll(): array
    {
        $result = [];
        $clients = $this->findAll();
        foreach ($clients as $client) {
            $result[] = new ClientDTO($client->getId(), $client->getName());
        }
        return $result;
    }

    public function getById(string $id): ?ClientDTO
    {
        $client = $this->find($id);
        if ($client == null) {
            return null;
        }
        return new ClientDTO($client->getId(), $client->getName());
    }


}
