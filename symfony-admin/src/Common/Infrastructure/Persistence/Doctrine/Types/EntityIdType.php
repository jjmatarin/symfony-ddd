<?php

namespace App\Common\Infrastructure\Persistence\Doctrine\Types;

use App\Common\Domain\Model\EntityId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;

class EntityIdType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => 26,
            'fixed' => true,
        ]);
    }

    public function getName(): string
    {
        return Types::STRING;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value == null) {
            return null;
        }
        if (is_string($value)) {
            return $value;
        }
        return $value->get();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value == null) {
            return null;
        }
        return EntityId::fromString($value);
    }

}