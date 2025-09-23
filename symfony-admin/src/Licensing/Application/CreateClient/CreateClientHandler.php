<?php

namespace App\Licensing\Application\CreateClient;

use App\Common\Bus\CommandHandlerInterface;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\LicenseTypeEnum;

readonly class CreateClientHandler implements CommandHandlerInterface
{
    public function __invoke(CreateClientCommand $command): void
    {
        Client::create(
            id: EntityId::fromString($command->id),
            name: $command->name,
            email: $command->email,
            description: $command->description,
            licenseType: LicenseTypeEnum::from($command->licenseType),
            productId: EntityId::fromString($command->productId),
        );
    }
}
