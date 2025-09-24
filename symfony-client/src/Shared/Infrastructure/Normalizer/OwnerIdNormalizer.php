<?php

namespace App\Shared\Infrastructure\Normalizer;

use App\Management\Domain\Model\Owner\OwnerId;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OwnerIdNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof OwnerId;
    }

    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === OwnerId::class && is_string($data);
    }

    public function normalize($object, ?string $format = null, array $context = []): string
    {
        return (string) $object->__toString();
    }

    public function denormalize($data, string $type, ?string $format = null, array $context = []): OwnerId
    {
        return OwnerId::fromString($data);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [OwnerId::class => true];
    }
}
