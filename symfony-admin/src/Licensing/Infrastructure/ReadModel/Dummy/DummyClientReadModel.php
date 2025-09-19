<?php

namespace App\Licensing\Infrastructure\ReadModel\Dummy;

use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Infrastructure\Persistence\Dummy\DummyClientRepository;
use App\Licensing\ReadModel\Client\ClientDTO;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;

class DummyClientReadModel implements ClientReadModelInterface
{
    public function __construct(
        private DummyClientRepository $dummyClientRepository
    ) {
    }

    public function listAll(): array
    {
        $clients = $this->dummyClientRepository->listAll();
        $result = [];
        /** @var Client $client */
        foreach ($clients as $client) {
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
        $client = $this->dummyClientRepository->getById(EntityId::fromString($id));
        if ($client == null) {
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
