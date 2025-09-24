<?php

namespace App\Shared\Domain\Model;

trait EntityIdTrait
{
    private const ULID_REGEX = '/^[0-9A-HJKMNP-TV-Z]{26}$/';

    public static function fromString(string $value): self
    {
        if (!preg_match(self::ULID_REGEX, $value)) {
            throw new \InvalidArgumentException(sprintf('Invalid ulid: "%s".', $value));
        }
        return new static($value);
    }

    public function __construct(
        public readonly string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
