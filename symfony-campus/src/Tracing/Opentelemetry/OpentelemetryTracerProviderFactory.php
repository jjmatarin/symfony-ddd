<?php

namespace App\Tracing\Opentelemetry;

use OpenTelemetry\Contrib\Otlp\OtlpHttpTransportFactory;
use OpenTelemetry\Contrib\Otlp\SpanExporter;
use OpenTelemetry\SDK\Sdk;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;

class OpentelemetryTracerProviderFactory
{
    private TracerProvider $tracerProvider;

    public function __construct(string $endpoint, string $serviceName)
    {
        $factory = new OtlpHttpTransportFactory();
        $transport = $factory->create($endpoint, 'application/json');
        $exporter = new SpanExporter($transport);

        $spanProcessor = new SimpleSpanProcessor($exporter);

        $this->tracerProvider = new TracerProvider(
            spanProcessors: [$spanProcessor]
        );

        $this->tracerProvider->getTracer($serviceName);

        Sdk::builder()
            ->setTracerProvider($this->tracerProvider)
            ->setAutoShutdown(true)
            ->buildAndRegisterGlobal();

    }

}
