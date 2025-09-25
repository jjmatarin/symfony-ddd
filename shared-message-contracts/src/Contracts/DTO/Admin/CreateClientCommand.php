<?php

namespace Contracts\DTO\Admin;

readonly class CreateClientCommand
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $description,
        public string $licenseType,
        public string $productId,
    ) {
    }
}
