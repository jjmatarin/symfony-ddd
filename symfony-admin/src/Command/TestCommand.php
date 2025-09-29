<?php

namespace App\Command;

use App\Common\Infrastructure\Tracing\Opentelemetry\OpentelemetryTracerProviderFactory;
use OpenTelemetry\API\Globals;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test',
    description: 'Add a short description for your command',
)]
class TestCommand extends Command
{
    public function __construct(
        OpentelemetryTracerProviderFactory $opentelemetryTracerProviderFactory,
    ) {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tracer = Globals::tracerProvider()->getTracer('symfony-messenger');

        $rootSpan = $tracer->spanBuilder('root-span')->startSpan();
        sleep(1);

        $rootScope = $rootSpan->activate(); // set the root span active in the current context

        try {
            $span1 = $tracer->spanBuilder('child-span-1')->startSpan();
            $internalScope = $span1->activate(); // set the child span active in the context

            try {
                /** @psalm-suppress ArgumentTypeCoercion */
                for ($i = 0; $i < 3; $i++) {
                    $loopSpan = $tracer->spanBuilder('loop-' . $i)->startSpan();
                    usleep((int) (0.5 * 1e6));
                    $loopSpan->end();
                }
            } finally {
                $internalScope->detach(); // deactivate child span, the rootSpan is set back as active
                $span1->end();
            }

            $span2 = $tracer->spanBuilder('child-span-2')->startSpan();
            sleep(1);
            $span2->end();
        } finally {
            $rootScope->detach(); // close the scope of the root span, no active span in the context now
            $rootSpan->end();
        }

// start the second root span
        $secondRootSpan = $tracer->spanBuilder('root-span-2')->startSpan();
        sleep(2);
        $secondRootSpan->end();


        return Command::SUCCESS;
    }
}
