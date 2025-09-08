<?php

namespace App\Licensing\Application\Client\GetClient;

use App\Common\Bus\QueryHandlerInterface;
use App\Common\Domain\Model\EntityId;
use App\Licensing\ReadModel\Client\ClientDTO;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;

readonly class GetClientHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientReadModelInterface $clientReadModel,
    ) {
    }

    public function __invoke(GetClientCommand $command): ClientDTO
    {
        return $this->clientReadModel->getById(EntityId::fromString($command->id));
    }
}
