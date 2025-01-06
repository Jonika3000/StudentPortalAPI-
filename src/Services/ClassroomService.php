<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\StudentRepository;

class ClassroomService
{
    public function __construct(
        private readonly StudentRepository $studentRepository,
    ) {
    }

    public function getClassroomByStudent(User $user): ?\App\Entity\Classroom
    {
        $student = $this->studentRepository->findOneBy(['associatedUser' => $user->getId()]);

        return $student->getClassroom();
    }

    public function getClassroomByTeacher(User $user): ?\App\Entity\Classroom
    {
        $student = $this->studentRepository->findOneBy(['associatedUser' => $user->getId()]);

        return $student->getClassroom();
    }
}
