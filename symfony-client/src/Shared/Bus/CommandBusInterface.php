<?php

namespace App\Shared\Bus;

interface CommandBusInterface
{
    public function execute(CommandRequestInterface $command): void;
}
