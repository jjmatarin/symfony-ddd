<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private string $identifier;
    private string $id;
    private array $roles;

    public function __construct(string $identifier, string $id, array $roles = ['ROLE_USER'])
    {
        $this->identifier = $identifier;
        $this->roles = $roles;
        $this->id = $id;
    }

    public function getUserIdentifier(): string
    {
        return $this->identifier;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {}
}
