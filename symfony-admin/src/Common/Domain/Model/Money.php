<?php

namespace App\Common\Domain\Model;

use Symfony\Component\Validator\Exception\InvalidArgumentException;

readonly class Money
{
    public static function clone(self $money): self
    {
        return new self($money->amount, $money->currency);
    }

    public function __construct(
        public int $amount,
        public Currency $currency
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount must be non-negative');
        }
    }

    public function equals(self $other): bool
    {
        return $this->amount === $other->amount && $this->currency->equals($other->currency);
    }

    public function add(self $money): self
    {
        return new self($money->amount + $this->amount, $this->currency);
    }
}
