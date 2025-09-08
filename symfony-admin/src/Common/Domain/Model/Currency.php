<?php

namespace App\Common\Domain\Model;

use Symfony\Component\Validator\Exception\InvalidArgumentException;

readonly class Currency
{
    public function __construct(
        public string $isoCode
    ) {
        if (!preg_match('/^[A-Z]{3}$/', $isoCode)) {
            throw new InvalidArgumentException();
        }
    }

    public function equals(self $other): bool
    {
        return $this->isoCode === $other->isoCode;
    }
}
