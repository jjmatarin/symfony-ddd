<?php

namespace App\Management\EventHandler;

use App\Management\Application\Owner\CreateOwner\CreateOwnerCommand;
use App\Shared\Bus\CommandBusInterface;
use App\Shared\Bus\IntegrationEventHandlerInterface;
use Contracts\Events\Admin\ClientWasCreated;

class CreateOwnerCommandHandler implements IntegrationEventHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(\Contracts\Commands\Client\CreateOwnerCommand $event): void
    {
        $command = new CreateOwnerCommand($event->id, $event->name, $event->email);
        $this->commandBus->execute($command);
    }
}
