<?php

namespace App\Licensing\Application\Client\ChangeClientLicense;

use App\Common\Bus\CommandHandlerInterface;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\ClientRepository;
use App\Licensing\Domain\Model\Client\LicenseTypeEnum;

readonly class ChangeClientLicenseHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(ChangeClientLicenseCommand $command): void
    {
        $client = $this->clientRepository->getById(EntityId::fromString($command->id));
        $client->changeLicense(LicenseTypeEnum::from($command->licenseType), EntityId::fromString($command->productId));
    }
}
