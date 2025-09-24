<?php

namespace App\Management\Application\Owner\GetOwner;

use App\Management\Domain\Model\Owner\Owner;
use App\Management\Domain\Model\Owner\OwnerId;
use App\Management\Domain\Model\Owner\OwnerRepositoryInterface;
use App\Shared\Bus\QueryHandlerInterface;
use App\Shared\Domain\Model\Email;
use App\Shared\Domain\Model\ShortDescription;

readonly class GetOwnerHandler implements QueryHandlerInterface
{
    public function __construct(
        private OwnerRepositoryInterface $ownerRepository,
    ) {
    }

    public function __invoke(GetOwnerQuery $query): mixed
    {
        return GetOwnerResponse::fromEntity($this->ownerRepository->getById(OwnerId::fromString($query->id)));
    }
}
