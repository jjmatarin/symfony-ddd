<?php

namespace App\Common\Domain\Model;

readonly class Money
{
    public function __construct(
        public int $amount,
        public Currency $currency
    ) {
        if ($amount < 0) {
            throw new \Exception('Amount must be non-negative');
        }
    }

    public function equals(Money $money): bool
    {
        return $this->amount === $money->amount && $this->currency->equals($money->currency);
    }

    public function add(int $amount): self
    {
        return new self($this->amount + $amount, $this->currency);
    }
}
