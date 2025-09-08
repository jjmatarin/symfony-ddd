<?php

namespace App\Licensing\Projection;

use App\Licensing\Domain\Model\Client\ClientWasCreated;
use App\Licensing\Domain\Model\Client\ClientWasDeleted;
use App\Licensing\Domain\Model\Client\ClientWasUpdated;
use App\Licensing\Domain\Model\Client\LicenseWasChanged;
use App\Licensing\Infrastructure\ReadModel\Elastic\ElasticClientReadModel;
use App\Licensing\ReadModel\Client\ClientDTO;

readonly class ClientProjector
{
    public function __construct(
        private ElasticClientReadModel $elasticClientReadModel
    ) {
    }

    public function onClientCreated(ClientWasCreated $event): void
    {
        $this->elasticClientReadModel->create(new ClientDTO($event->id, $event->name, $event->description, $event->licenseType));
    }

    public function onClientUpdated(ClientWasUpdated $event): void
    {
        $this->elasticClientReadModel->update($event->id, [
            'name' => $event->name,
            'description' => $event->description,
        ]);
    }

    public function onClientDeleted(ClientWasDeleted $event): void
    {
        $this->elasticClientReadModel->delete($event->id);
    }

    public function onLicenseChanged(LicenseWasChanged $event): void
    {
        $this->elasticClientReadModel->update($event->id, [
            'licenseType' => $event->licenseType,
        ]);
    }
}
