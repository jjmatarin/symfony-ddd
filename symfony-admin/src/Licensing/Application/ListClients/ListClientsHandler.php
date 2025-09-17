<?php

namespace App\Licensing\Application\ListClients;

use App\Common\Bus\QueryHandlerInterface;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

readonly class ListClientsHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    /**
     * @return ListClientsItem[]
     */
    public function __invoke(ListClientsQuery $command): array
    {
        $clients = $this->clientRepository->listAll();

        $result = [];
        foreach ($clients as $client) {
            $result[] = new ListClientsItem(
                id: $client->getId()->get(),
                name: $client->getName(),
                email: $client->getEmail(),
                status: $client->getStatus()->value,
            );
        }
        return $result;
    }
}
