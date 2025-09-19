<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\CommandBusInterface;
use App\Common\Bus\CommandRequestInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $commandBus
    ) {
    }

    public function execute(CommandRequestInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}