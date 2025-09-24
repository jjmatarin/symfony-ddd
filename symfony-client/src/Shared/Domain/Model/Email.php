<?php

namespace App\Shared\Domain\Model;

readonly class Email
{
    public static function fromString(string $email): self
    {
        $email = trim($email);

        if ($email === '') {
            throw new \InvalidArgumentException('Empty email');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('Invalid email: "%s".', $email));
        }

        $parts = explode('@', $email, 2);
        if (count($parts) !== 2) {
            throw new \InvalidArgumentException(sprintf('Invalid email: "%s".', $email));
        }
        [$local, $domain] = $parts;

        $normalized = $local . '@' . mb_strtolower($domain);

        return new self($normalized);
    }

    private function __construct(
        public string $value
    ) {
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}
