<?php

namespace App\Licensing\ReadModel\Client;

interface ClientReadModelInterface
{
    /**
     * @return ClientDTO[]
     */
    public function listAll(): array;
    public function getById(string $id): ?ClientDTO;
}