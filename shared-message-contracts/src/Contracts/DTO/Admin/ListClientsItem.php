<?php

namespace Contracts\DTO\Admin;

class ListClientsItem
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public ListClientsItemProduct $activeProduct
    ) {
    }
}
