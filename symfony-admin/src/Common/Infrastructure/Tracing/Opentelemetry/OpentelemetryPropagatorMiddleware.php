<?php

namespace App\Common\Infrastructure\Tracing\Opentelemetry;

use Contracts\Stamps\TraceContextStamp;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use OpenTelemetry\Context\Propagation\ArrayAccessGetterSetter;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class OpentelemetryPropagatorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private OpentelemetryTracerProviderFactory $tracer,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $propagator = TraceContextPropagator::getInstance();
        $carrier = ArrayAccessGetterSetter::getInstance();

        $context = $propagator->extract([], $carrier);

        $headers = [];
        $propagator->inject($headers, $carrier, $context);
        $envelope = $envelope->with(new TraceContextStamp($headers));

        return $stack->next()->handle($envelope, $stack);
    }
}
