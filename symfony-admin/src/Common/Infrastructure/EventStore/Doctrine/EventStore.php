<?php

namespace App\Common\Infrastructure\EventStore\Doctrine;

use App\Common\Domain\EventHandling\DomainEventBase;
use App\Common\Domain\Model\EntityId;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventStore
{
    public function __construct(
        private NormalizerInterface $normalizer,
        private DenormalizerInterface $denormalizer,
        private EntityManagerInterface $entityManager,

    ) {
    }

    public function append(DomainEventBase $event): void
    {
        $storedEvent = new StoredEvent(
            $event->id,
            $event->aggregateType,
            $event->playhead,
            get_class($event),
            $this->normalizer->normalize($event),
        );
        $this->entityManager->persist($storedEvent);

        if ($event->playhead % 2 === 0 && $event->playhead !== 0) {
            $aggregate = $this->getById($event->aggregateType, $event->id);
            $snapshot = Snapshot::create($event->id, $event->aggregateType, $event->playhead, $aggregate->toSnapshot());
            $this->entityManager->persist($snapshot);
        }
    }

    public function getById(string $aggregateType, string $id): mixed
    {
        $snapshot = $this->getSnapshot($id);

        $storedEvents = $this->listEvents($id, $snapshot);
        if (count($storedEvents) === 0 && !$snapshot) {
            return null;
        }
        $events = [];
        /** @var StoredEvent $storedEvent */
        foreach ($storedEvents as $storedEvent) {
            $events[] = $this->denormalizer->denormalize($storedEvent->getPayload(), $storedEvent->getEventType());
        }


        if ($snapshot) {
            return $aggregateType::fromSnapshot($snapshot->getPayload(), $snapshot->getLastPlayhead(), $events);
        }
        return $aggregateType::hydrateFromEvents($events);
    }

    private function listEvents(string $id, ?Snapshot $snapshot): array
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from(StoredEvent::class, 'e')
            ->where('e.aggregateId = :id')
            ->orderBy('e.playhead')
            ->setParameter('id', $id)
        ;
        if ($snapshot) {
            $qb->andWhere('e.playhead > :playhead');
            $qb->setparameter('playhead', $snapshot->getLastPlayhead());
        }
        return $qb->getQuery()->getResult();
    }

    private function getSnapshot(string $id): ?Snapshot
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('s')
            ->from(Snapshot::class, 's')
            ->where('s.aggregateId = :id')
            ->orderBy('s.lastPlayhead', 'DESC')
            ->setParameter('id', $id)
            ->setMaxResults(1)
        ;
        return $qb->getQuery()->getOneOrNullResult();

    }
}
