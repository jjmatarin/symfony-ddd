<?php

namespace App\Security\Infrastructure\Symfony;

use Symfony\Component\Security\Core\User\UserInterface;

readonly class User implements UserInterface
{
    public function __construct(
        public string $id,
        public string $token,
        public array $roles = [],
    ) {
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }
}
