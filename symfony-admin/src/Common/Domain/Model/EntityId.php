<?php

namespace App\Common\Domain\Model;

use Symfony\Component\Uid\Ulid;

class EntityId
{
    private Ulid $ulid;

    public static function fromString(string $id): self
    {
        return new static(Ulid::fromString($id));
    }

    public static function generate(): self
    {
        return self::fromString(Ulid::generate());
    }

    private function __construct(Ulid $ulid)
    {
        $this->ulid = $ulid;
    }

    public function get(): string
    {
        return $this->ulid->toString();
    }

    public function __toString(): string
    {
        return $this->get();
    }
}