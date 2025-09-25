<?php

namespace App\Service;

use App\Entity\Process;
use App\Repository\ProcessRepository;
use Client\AdminClient;
use Contracts\Commands\Client\CreateOwnerCommand;
use Contracts\Events\Admin\ClientWasCreated;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;

class ClientProcessService implements MarkingStoreInterface
{
    public function __construct(
        private ProcessRepository $processRepository,
        private MessageBusInterface $messageBus
    ) {
    }

    public function getMarking(object $subject): Marking
    {
        /** @var Process $subject */
        return new Marking([$subject->getCurrentPlace() => 1]);
    }

    public function setMarking(object $subject, Marking $marking, array $context = []): void
    {
        /** @var ClientWasCreated $event */
        $event = $context['event'];

        $this->messageBus->dispatch(new CreateOwnerCommand($event->id, $event->name, 'qqqq@qqqq.com'), [new AmqpStamp('client.create-owner')]);

        $marking = key($marking->getPlaces());
        $subject->setCurrentPlace($marking);
        $this->processRepository->save($subject, true);
    }
}
