<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\StudentRepository;

class LessonService
{
    public function __construct(
        private StudentRepository $studentRepository,
    ) {
    }

    public function getLessonsByStudent(User $user): \Doctrine\Common\Collections\Collection
    {
        $student = $this->studentRepository->findOneBy(['associatedUser' => $user->getId()]);

        $classroom = $student->getClassroom();

        return $classroom->getLessons();
    }
}
