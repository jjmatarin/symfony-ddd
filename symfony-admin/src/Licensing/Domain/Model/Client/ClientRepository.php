<?php

namespace App\Licensing\Domain\Model\Client;

use App\Common\Domain\Model\EntityId;

interface ClientRepository
{
    public function getById(EntityId $id): ?Client;
    public function persist(Client $client): void;
}
