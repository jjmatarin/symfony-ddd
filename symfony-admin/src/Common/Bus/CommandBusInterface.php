<?php

namespace App\Common\Bus;

interface CommandBusInterface
{
    public function execute(CommandRequestInterface $command): void;
}
