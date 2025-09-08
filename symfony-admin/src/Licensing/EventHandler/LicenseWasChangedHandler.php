<?php

namespace App\Licensing\EventHandler;

use App\Common\Bus\EventHandlerInterface;
use App\Licensing\Domain\Model\Client\LicenseWasChanged;
use App\Licensing\Projection\ClientProjector;

readonly class LicenseWasChangedHandler implements EventHandlerInterface
{
    public function __construct(
        private ClientProjector $clientProjector
    ) {
    }

    public function __invoke(LicenseWasChanged $event): void
    {
        $this->projectReadModel($event);
    }

    private function projectReadModel(LicenseWasChanged $event): void
    {
        $this->clientProjector->onLicenseChanged($event);
    }
}
