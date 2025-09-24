<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Bus\CommandBusInterface;
use App\Shared\Bus\CommandRequestInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus,
    ) {
        $this->messageBus = $commandBus;
    }

    public function execute(CommandRequestInterface $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
