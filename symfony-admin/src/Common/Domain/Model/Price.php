<?php

namespace App\Common\Domain\Model;

readonly class Price
{
    public function __construct(
        public Money $money,
        public \DateTimeImmutable $date
    ) {
    }

    public function update(Money $money, \DateTimeImmutable $date): self
    {
        return new self($money, $date);
    }
}
