<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\CommandRequestInterface;
use App\Common\Bus\QueryBusInterface;
use App\Common\Bus\QueryRequestInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus
    ) {
        $this->messageBus = $queryBus;
    }

    public function execute(QueryRequestInterface $command): mixed
    {
        return $this->handle($command);
    }

}