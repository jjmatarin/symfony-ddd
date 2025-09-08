<?php

namespace App\Licensing\Application\Client\CreateClient;

use App\Common\Bus\CommandHandlerInterface;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientRepository;
use App\Licensing\Domain\Model\Client\LicenseTypeEnum;

readonly class CreateClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(CreateClientCommand $command): CreateClientResponse
    {
        $client = Client::create(EntityId::generate(), $command->name, $command->description, LicenseTypeEnum::from($command->licenseType), EntityId::fromString($command->productId));
        $this->clientRepository->persist($client);

        return new CreateClientResponse($client->getId());
    }
}
