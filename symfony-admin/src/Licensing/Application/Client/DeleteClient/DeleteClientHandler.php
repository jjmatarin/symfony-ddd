<?php

namespace App\Licensing\Application\Client\DeleteClient;

use App\Common\Bus\CommandHandlerInterface;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\ClientRepository;

readonly class DeleteClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(DeleteClientCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        $client->delete();
    }
}
