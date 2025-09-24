<?php

namespace App\Management\Application\Owner\CreateOwner;

use App\Shared\Bus\CommandHandlerInterface;
use App\Management\Domain\Model\Owner\Owner;
use App\Management\Domain\Model\Owner\OwnerId;
use App\Management\Domain\Model\Owner\OwnerRepositoryInterface;
use App\Shared\Domain\Model\Email;
use App\Shared\Domain\Model\ShortDescription;

readonly class CreateOwnerHandler implements CommandHandlerInterface
{
    public function __construct(
        private OwnerRepositoryInterface $ownerRepository,
    ) {
    }

    public function __invoke(CreateOwnerCommand $command): void
    {
        $owner = Owner::create(
            OwnerId::fromString($command->id),
            ShortDescription::fromString($command->name),
            Email::fromString($command->email),
        );
        $this->ownerRepository->persist($owner);
    }
}
