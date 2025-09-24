<?php

namespace App\Management\Domain\Model\Owner;

use App\Shared\Domain\Model\Email;
use App\Shared\Domain\Model\ShortDescription;
use App\Shared\EventHandling\DomainEventPublisher;

class Owner
{
    private OwnerId $id;
    private ShortDescription $name;
    private Email $email;

    public static function create(
        OwnerId $id,
        ShortDescription $name,
        Email $email,
    ): self {
        return new self($id, $name, $email);
    }

    private function __construct(
        OwnerId $id,
        ShortDescription $name,
        Email $email,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;

        DomainEventPublisher::getInstance()->publish(new OwnerWasCreated(
            $id, $name, $email
        ));
    }

    public function getId(): OwnerId
    {
        return $this->id;
    }

    public function getName(): ShortDescription
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
