<?php

namespace App\Shared\Domain\Model;

readonly class ShortDescription
{
    public static function fromString(string $value): self
    {
        return new self($value);
    }

    private function __construct(
        public string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
