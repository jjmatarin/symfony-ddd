<?php

namespace App\Licensing\Application\GetClient;

use App\Common\Bus\QueryHandlerInterface;
use App\Common\Domain\Exception\NotFoundException;
use App\Common\Domain\Model\EntityId;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;

readonly class GetClientHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientReadModelInterface $clientReadModel,
    ) {
    }

    public function __invoke(GetClientQuery $command): GetClientResponse
    {
        $client = $this->clientReadModel->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new NotFoundException("Client not found");
        }

        return new GetClientResponse(
            id: $client->id,
            name: $client->name,
            email: $client->email,
            status: $client->status,
            activeLicenseType: $client->activeLicenseType,
            activeProductId: $client->activeProductId
        );
    }
}
