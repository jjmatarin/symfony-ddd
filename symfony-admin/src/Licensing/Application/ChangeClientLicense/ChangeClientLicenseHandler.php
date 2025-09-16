<?php

namespace App\Licensing\Application\ChangeClientLicense;

use App\Common\Domain\Model\EntityId;
use App\Licensing\Application\ActivateClient\ActivateClientCommand;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;
use App\Licensing\Domain\Model\Client\LicenseTypeEnum;

readonly class ChangeClientLicenseHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function __invoke(ChangeClientLicenseCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        if ($client === null) {
            throw new \Exception("Client not found");
        }

        $client->changeLicense(LicenseTypeEnum::from($command->licenseType), EntityId::fromString($command->productId));
    }
}
