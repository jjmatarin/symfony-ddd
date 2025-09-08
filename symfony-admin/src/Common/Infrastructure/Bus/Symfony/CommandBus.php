<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\CommandBusInterface;
use App\Common\Bus\CommandRequestInterface;
use App\Common\Bus\CommandResponseInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function execute(CommandRequestInterface $command): null|array|CommandResponseInterface
    {
        return $this->handle($command);
    }
}
