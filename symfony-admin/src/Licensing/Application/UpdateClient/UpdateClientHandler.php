<?php

namespace App\Licensing\Application\UpdateClient;

use App\Common\Bus\CommandHandlerInterface;
use App\Common\Domain\Exception\NotFoundException;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

readonly class UpdateClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(UpdateClientCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new NotFoundException("Client not found");
        }

        $client->update($command->name, $command->email, $command->description);
    }
}
