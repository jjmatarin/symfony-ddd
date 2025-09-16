<?php

namespace App\Licensing\Application\ActivateClient;

use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

readonly class ActivateClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(ActivateClientCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new \Exception("Client not found");
        }

        $client->activate();
    }
}
