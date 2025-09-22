<?php

namespace App\Licensing\Infrastructure\Projector;

use App\Common\Bus\QueryBusInterface;
use App\Licensing\Application\GetProduct\GetProductQuery;
use App\Licensing\Domain\Model\Client\ClientLicenseWasChanged;
use App\Licensing\Domain\Model\Client\ClientWasCreated;
use App\Licensing\Domain\Model\Client\ClientWasDeleted;
use App\Licensing\Domain\Model\Client\ClientWasUpdated;
use App\Licensing\ReadModel\Client\ClientReadModelInterface;

class ClientProjector
{
    public function __construct(
        private ClientReadModelInterface $clientReadModel,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function onClientCreated(ClientWasCreated $event): void
    {
        $product = $this->queryBus->execute(new GetProductQuery($event->productId));
        $this->clientReadModel->create($event->id, [
            'name' => $event->name,
            'email' => $event->email,
            'description' => $event->description,
            'activeLicenseType' => $event->licenseType,
            'activeProduct' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
            ],
        ]);
    }

    public function onClientUpdated(ClientWasUpdated $event): void
    {
        $this->clientReadModel->update($event->id, [
            'name' => $event->name,
            'email' => $event->email,
            'description' => $event->description,
        ]);
    }

    public function onClientDeleted(ClientWasDeleted $event): void
    {
        $this->clientReadModel->delete($event->id);
    }

    public function onClientLicenseChanged(ClientLicenseWasChanged $event): void
    {
        $product = $this->queryBus->execute(new GetProductQuery($event->productId));

        $this->clientReadModel->update($event->id, [
            'activeLicenseType' => $event->licenseType,
            'activeProduct' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
            ],
        ]);
    }
}
