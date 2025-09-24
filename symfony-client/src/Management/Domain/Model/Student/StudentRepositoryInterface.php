<?php

namespace App\Management\Domain\Model\Student;

interface StudentRepositoryInterface
{
    public function getById(StudentId $id): ?Student;
    public function persist(Student $student): void;
}
