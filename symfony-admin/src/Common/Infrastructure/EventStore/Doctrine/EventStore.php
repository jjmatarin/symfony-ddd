<?php

namespace App\Common\Infrastructure\EventStore\Doctrine;

use App\Common\Domain\EventHandling\DomainEventBase;
use App\Common\Domain\Model\EntityId;
use App\Licensing\Domain\Model\Client\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventStore
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NormalizerInterface $normalizer,
        private DenormalizerInterface $denormalizer
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
        //$this->entityManager->flush();
    }

    public function getById(string $aggregateType, EntityId $id): ?Client
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from(StoredEvent::class, 'e')
            ->where('e.aggregateId = :id')
            ->orderBy('e.playhead')
            ->setParameter('id', $id)
        ;
        $storedEvents = $qb->getQuery()->getResult();
        if (count($storedEvents) == 0) {
            return null;
        }
        $events = [];
        /** @var StoredEvent $storedEvent */
        foreach ($storedEvents as $storedEvent) {
            $events[] = $this->denormalizer->denormalize($storedEvent->getPayload(), $storedEvent->getEventType());
        }
        return $aggregateType::hydrateFromEvents($events);
    }
}
