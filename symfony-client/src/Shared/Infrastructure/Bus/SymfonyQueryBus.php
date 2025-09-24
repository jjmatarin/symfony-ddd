<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Bus\QueryBusInterface;
use App\Shared\Bus\QueryRequestInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus,
    ) {
        $this->messageBus = $queryBus;
    }

    public function query(QueryRequestInterface $request): mixed
    {
        return $this->handle($request);
    }
}
