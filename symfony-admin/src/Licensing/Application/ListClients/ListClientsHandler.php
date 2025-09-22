<?php

namespace App\Licensing\Application\ListClients;

use App\Common\Bus\QueryHandlerInterface;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;

readonly class ListClientsHandler implements QueryHandlerInterface
{
    public function __construct(
        private ClientReadModelInterface $clientReadModel,
    ) {
    }

    /**
     * @return ListClientsItem[]
     */
    public function __invoke(ListClientsQuery $command): array
    {
        $clients = $this->clientReadModel->listAll();

        $result = [];
        foreach ($clients as $client) {
            $result[] = new ListClientsItem(
                id: $client->id,
                name: $client->name,
                email: $client->email,
                activeProduct: new ListClientsItemProduct(
                    id: $client->activeProduct->id,
                    name: $client->activeProduct->name,
                    price: $client->activeProduct->price,
                )
            );
        }
        return $result;
    }
}
