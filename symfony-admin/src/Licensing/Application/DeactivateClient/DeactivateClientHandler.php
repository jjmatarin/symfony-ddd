<?php

namespace App\Licensing\Application\DeactivateClient;

use App\Common\Bus\CommandHandlerInterface;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

readonly class DeactivateClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(DeactivateClientCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new \Exception("Client not found");
        }

        $client->deactivate();
    }
}
