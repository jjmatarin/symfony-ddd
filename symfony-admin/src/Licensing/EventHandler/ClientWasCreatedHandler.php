<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\CommandBusInterface;
use App\Common\Bus\DomainEventHandlerInterface;
use App\Licensing\Application\ActivateClient\ActivateClientCommand;
use App\Licensing\Domain\Model\Client\ClientWasCreated;

class ClientWasCreatedHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function __invoke(ClientWasCreated $event): void
    {
        $command = new ActivateClientCommand($event->id);
        $this->commandBus->execute($command);
    }
}