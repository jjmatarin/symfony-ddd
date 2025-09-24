<?php

namespace App\Shared\Bus;

interface QueryBusInterface
{
    public function query(QueryRequestInterface $request): mixed;
}
