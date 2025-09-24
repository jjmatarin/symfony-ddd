<?php

namespace App\Management\Domain\Model\Owner;

interface OwnerRepositoryInterface
{
    public function getById(OwnerId $id): ?Owner;
    public function persist(Owner $owner): void;
}
