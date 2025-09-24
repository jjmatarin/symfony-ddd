<?php

namespace App\Management\Application\Owner\GetOwner;

use App\Management\Domain\Model\Owner\Owner;
use App\Shared\Bus\QueryRequestInterface;

readonly class GetOwnerResponse implements QueryRequestInterface
{
    public static function fromEntity(Owner $owner): self
    {
        return new self(
            $owner->getId()->value,
            $owner->getName()->value,
            $owner->getEmail()->value
        );
    }

    public function __construct(
        public string $id,
        public string $name,
        public string $email
    ) {
    }
}
