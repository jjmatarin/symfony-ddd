<?php

namespace App\Licensing\Domain\Model\Client;

readonly class ClientWasCreated
{
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $description,
        string $licenseType,
        string $productId,
    ) {

    }
}
