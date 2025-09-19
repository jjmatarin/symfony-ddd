<?php

namespace App\Licensing\Application\ListClients;

class ListClientsItem
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $status,
    ) {
    }

}