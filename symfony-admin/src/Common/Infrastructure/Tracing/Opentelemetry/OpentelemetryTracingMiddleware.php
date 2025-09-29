<?php

namespace App\Common\Infrastructure\Tracing\Opentelemetry;

use Contracts\Stamps\TraceContextStamp;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Propagation\ArrayAccessGetterSetter;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\BusNameStamp;

class OpentelemetryTracingMiddleware implements MiddlewareInterface
{
    public function __construct(
        private OpentelemetryTracerProviderFactory $tracer
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $propagator = TraceContextPropagator::getInstance();
        $getterSetter = ArrayAccessGetterSetter::getInstance();

        $stamp = $envelope->last(TraceContextStamp::class);
        $traceHeaders = $stamp?->traceHeaders?? [];
        $context = $propagator->extract(
            $traceHeaders,
            $getterSetter
        );
        $busname = $envelope->last(BusNameStamp::class)->getBusName();
        $tracer = Globals::tracerProvider()->getTracer($busname);

        $message = $envelope->getMessage();
        $className = get_class($message);

        // Crear un span para el procesamiento del mensaje
        $span = $tracer
            ->spanBuilder("$busname: $className")
            ->setParent($context)
            ->setSpanKind(SpanKind::KIND_CONSUMER)
            ->startSpan();

        $scope = $span->activate();


        try {
            $envelope = $stack->next()->handle($envelope, $stack);
        } catch (\Throwable $e) {
            $span->recordException($e);
            $span->setStatus(StatusCode::STATUS_ERROR, $e->getMessage());
            throw $e;
        } finally {
            $span->end();
            $scope->detach();
        }

        return $envelope;

    }
}
