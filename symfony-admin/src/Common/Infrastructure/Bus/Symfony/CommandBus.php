<?php

namespace App\Common\Infrastructure\Bus\Symfony;

use App\Common\Bus\CommandBusInterface;
use App\Common\Bus\CommandRequestInterface;
use Contracts\Stamps\SecurityTokenStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    public function execute(CommandRequestInterface $command): void
    {
        $token = $this->tokenStorage->getToken();
        $jwtToken = $token->getUser()->token;

        $this->commandBus->dispatch($command, [
            new SecurityTokenStamp($jwtToken)
        ]);
    }
}
