<?php

namespace App\EventHandler;

use App\Entity\Process;
use App\Repository\ProcessRepository;
use Contracts\Events\Admin\ClientWasCreated;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsMessageHandler]
class ClientWasCreatedHandler
{
    public function __construct(
        private ProcessRepository $processRepository,
        private WorkflowInterface $clientProcessStateMachine,
    ) {
    }

    public function __invoke(ClientWasCreated $event): void
    {
        $process = new Process();
        $process->setClientId($event->id);
        $this->processRepository->save($process, true);

        $this->clientProcessStateMachine->apply($process, 'to_create_owner', [
            'event' => $event,
        ]);
    }
}
