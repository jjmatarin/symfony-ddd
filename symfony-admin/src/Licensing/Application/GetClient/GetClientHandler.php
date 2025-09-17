<?php

namespace App\Licensing\Application\GetClient;

use App\Common\Bus\QueryHandlerInterface;
use App\Common\Domain\Exception\NotFoundException;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

readonly class GetClientHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(GetClientQuery $command): GetClientResponse
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new NotFoundException("Client not found");
        }

        return new GetClientResponse(
            id: $client->getId()->get(),
            name: $client->getName(),
            email: $client->getEmail(),
            status: $client->getStatus()->value,
            activeLicenseType: $client->getActiveLicenseType()->value,
            activeProductId: $client->getActiveLicenseProductId()->get()
        );
    }
}
