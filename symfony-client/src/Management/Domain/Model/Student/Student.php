<?php

namespace App\Management\Domain\Model\Student;

use App\Management\Domain\Model\Owner\OwnerId;
use App\Management\Domain\Model\Owner\OwnerWasCreated;
use App\Shared\Domain\Model\Email;
use App\Shared\EventHandling\DomainEventPublisher;

class Student
{
    private StudentId $id;
    private OwnerId $ownerId;
    private string $name;
    private Email $email;

    public static function create(
        StudentId $id,
        OwnerId   $ownerId,
        string    $name,
        Email     $email,
    ): Student {
        return new self($id, $ownerId, $name, $email);
    }

    private function __construct(
        StudentId $id,
        OwnerId   $ownerId,
        string    $name,
        Email     $email,
    ) {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->name = $name;
        $this->email = $email;

        DomainEventPublisher::getInstance()->publish(new StudentWasCreated(
            $id, $ownerId, $name, $email
        ));
    }

    public function getId(): StudentId
    {
        return $this->id;
    }

    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
