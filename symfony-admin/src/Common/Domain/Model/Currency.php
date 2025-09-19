<?php

namespace App\Common\Domain\Model;

readonly class Currency
{
    public function __construct(
        public string $isoCode
    ) {
        if (!preg_match('/^[A-Z]{3}$/', $isoCode)) {
            throw new \Exception("Invalid currency iso code");
        }
    }

    public function equals(Currency $currency): bool
    {
        return $this->isoCode === $currency->isoCode;
    }
}
