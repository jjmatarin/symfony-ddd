<?php

namespace App\Common\Domain\Model;

readonly class Price
{
    public function __construct(
        public Money $money,
        public \DateTimeImmutable $date,
    ) {
    }
}
