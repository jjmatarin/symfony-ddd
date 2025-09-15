<?php

namespace App\Common\Infrastructure\Persistence\Doctrine\Types;

use App\Common\Domain\Model\Currency;
use App\Common\Domain\Model\Money;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class MoneyType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return 'money';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string|null|false
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof Money) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                [Money::class]
            );
        }

        return json_encode([
            'amount' => $value->amount,
            'currency' => $value->currency->isoCode,
        ], JSON_THROW_ON_ERROR);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Money
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Money) {
            return $value;
        }

        $data = is_string($value) ? json_decode($value, true) : $value;

        if (!is_array($data) || !isset($data['amount'], $data['currency'])) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return new Money((int) $data['amount'], new Currency($data['currency']));
    }

}