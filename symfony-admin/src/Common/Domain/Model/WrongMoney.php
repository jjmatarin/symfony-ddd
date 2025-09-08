<?php

namespace App\Common\Domain\Model;

use Symfony\Component\Validator\Exception\InvalidArgumentException;

class WrongMoney
{
    public function __construct(
        public int $amount,
        public Currency $currency
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount must be non-negative');
        }
    }

    public function add(WrongMoney $money): void
    {
        $this->amount += $money->amount;
    }
}
