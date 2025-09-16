<?php

namespace App\Licensing\Application\DeleteClient;

use App\Common\Domain\Model\EntityId;
use App\Licensing\Application\ActivateClient\ActivateClientCommand;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

readonly class DeleteClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(DeleteClientCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new \Exception("Client not found");
        }

        $client->delete();
    }
}
