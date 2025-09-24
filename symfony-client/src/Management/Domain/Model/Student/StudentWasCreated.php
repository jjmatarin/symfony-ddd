<?php

namespace App\Management\Domain\Model\Student;

use App\Shared\Bus\DomainEventInterface;

readonly class StudentWasCreated implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public string $ownerId,
        public string $name,
        public string $email,
    ) {
    }
}
