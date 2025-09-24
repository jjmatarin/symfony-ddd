<?php

namespace App\Shared\Infrastructure\Normalizer;

use App\Shared\Domain\Model\ShortDescription;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ShortDescriptionNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ShortDescription;
    }

    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === ShortDescription::class && is_string($data);
    }

    public function normalize($object, ?string $format = null, array $context = []): string
    {
        return (string) $object->__toString();
    }

    public function denormalize($data, string $type, ?string $format = null, array $context = []): ShortDescription
    {
        return ShortDescription::fromString($data);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [ShortDescription::class => true];
    }
}
