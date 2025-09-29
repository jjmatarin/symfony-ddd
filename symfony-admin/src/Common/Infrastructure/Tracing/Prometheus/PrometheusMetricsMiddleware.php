<?php

namespace App\Common\Infrastructure\Tracing\Prometheus;

use Prometheus\CollectorRegistry;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class PrometheusMetricsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private CollectorRegistry $registry,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $counter = $this->registry
            ->getOrRegisterCounter('app', 'messenger_messages_total', 'Total de mensajes procesados', ['type']);

        $histogram = $this->registry
            ->getOrRegisterHistogram('app', 'messenger_message_duration_seconds', 'Duración de mensajes', ['type'], [0.1, 0.5, 1, 5, 10]);

        $type = get_class($envelope->getMessage());

        $start = microtime(true);

        try {
            $result = $stack->next()->handle($envelope, $stack);

            $counter->inc([$type]);
        } catch (\Throwable $e) {
            $counter->inc([$type.'_failed']);
            throw $e;
        } finally {
            $duration = microtime(true) - $start;
            $histogram->observe($duration, [$type]);
        }

        return $result;
    }
}
