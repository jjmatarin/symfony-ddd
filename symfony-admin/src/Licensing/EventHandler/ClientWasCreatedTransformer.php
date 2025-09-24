<?php

namespace App\Licensing\EventHandler;

use Contracts\Events\Admin\ClientWasCreated;

class ClientWasCreatedTransformer
{
    public function __invoke(\App\Licensing\Domain\Model\Client\ClientWasCreated $event): ClientWasCreated
    {
        return new ClientWasCreated(
            $event->id, $event->name, $event->email
        );
    }
}
