<?php

namespace App\Licensing\Infrastructure\Persistence\Dummy;

use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use App\Licensing\Domain\Model\Client\ClientRepositoryInterface;

class DummyClientRepository implements ClientRepositoryInterface
{
    private static $items = [];

    public function getById(EntityId $id): ?Client
    {
        if (isset(self::$items->items[$id->get()])) {
            return self::$items[$id->get()];
        }
        return null;
    }

    public function persist(Client $client): void
    {
        self::$items[$client->getId()->get()] = $client;
    }

    public function listAll(): array
    {
        return self::$items;
    }
}
