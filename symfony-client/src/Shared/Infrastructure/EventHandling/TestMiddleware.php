<?php

namespace App\Shared\Infrastructure\EventHandling;

use Contracts\Stamps\TestStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

readonly class TestMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $testStamp = $envelope->last(TestStamp::class);
        $envelope = $stack->next()->handle($envelope, $stack);

        return $envelope;
    }
}
