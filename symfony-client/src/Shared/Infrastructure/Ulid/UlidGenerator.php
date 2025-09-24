<?php

namespace App\Shared\Infrastructure\Ulid;

use Symfony\Component\Uid\Ulid;

class UlidGenerator
{
    public static function generate(): string
    {
        return Ulid::generate();
    }
}
