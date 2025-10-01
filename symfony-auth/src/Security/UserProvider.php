<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as TUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private array $users = [
        'admin' => ['password' => '1234', 'id' => '01K6D4C6S3WWA642Z0NYV5164D', 'roles' => ['ROLE_ADMIN']],
        'guest' => ['password' => 'guest', 'id' => '01K6D4CCFRZNV2579ENKTB55PR', 'roles' => ['ROLE_GUEST']],
    ];

    public function refreshUser(TUser $user): TUser
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException('Unsupported user class.');
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    public function loadUserByIdentifier(string $identifier): TUser
    {
        if (!isset($this->users[$identifier])) {
            throw new UserNotFoundException("User '$identifier' not found.");
        }

        return new User($identifier, $this->users[$identifier]['id'], $this->users[$identifier]['roles']);

    }
}
