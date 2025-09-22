<?php

namespace App\Common\Domain\Model;

readonly class Price
{
    public function __construct(
        public Money $money,
        public \DateTimeImmutable $date,
    ) {
    }

    public function getAmount(): float
    {
        return $this->money->amount / 100;
    }
}
