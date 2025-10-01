<?php

namespace App\Security\Infrastructure\Symfony;

use Contracts\Stamps\SecurityTokenStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityTokenPropagatorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $tokenStamp = $envelope->last(SecurityTokenStamp::class);
        if (null === $tokenStamp) {
            $envelope = $envelope->with(new SecurityTokenStamp($this->tokenStorage->getToken()->getUser()->token));
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
