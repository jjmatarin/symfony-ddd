<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\DomainEventHandlerInterface;
use App\Licensing\Domain\Model\Client\ClientLicenseWasChanged;
use App\Licensing\Infrastructure\Projector\ClientProjector;

class ClientLicenseWasChangedHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private ClientProjector $projector,
    ) {
    }

    public function __invoke(ClientLicenseWasChanged $event): void
    {
        $this->projector->onClientLicenseChanged($event);
    }
}
