<?php

namespace App\Licensing\Application\Client\ListClients;

use App\Common\Bus\QueryHandlerInterface;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;

readonly class ListClientsHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientReadModelInterface $clientReadModel,
    ) {
    }

    public function __invoke(ListClientsCommand $command): array
    {
        return $this->clientReadModel->listAll();
    }
}
