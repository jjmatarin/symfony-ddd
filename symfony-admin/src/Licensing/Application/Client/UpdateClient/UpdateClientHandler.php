<?php

namespace App\Licensing\Application\Client\UpdateClient;

use App\Common\Bus\CommandHandlerInterface;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\ClientRepository;

readonly class UpdateClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(UpdateClientCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        $client->update($command->name, $command->description);
    }
}
