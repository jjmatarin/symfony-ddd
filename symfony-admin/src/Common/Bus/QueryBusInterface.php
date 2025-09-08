<?php

namespace App\Common\Bus;

interface QueryBusInterface
{
    public function execute(QueryRequestInterface $command): null|array|QueryResponseInterface;
}
