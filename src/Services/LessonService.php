<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;

class LessonService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function getLessonsByStudent(User $user): array
    {
        $student = $this->userRepository->findOneBy(['associatedUser' => $user->getId()]);

        $classroom = $student->getClassroom();

        return $classroom->getLessons();
    }
}
