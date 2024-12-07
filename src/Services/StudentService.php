<?php

namespace App\Services;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

readonly class StudentService
{
    public function __construct(private StudentRepository $studentRepository)
    {
    }

    public function getStudentByToken(TokenInterface $token): Student
    {
        $user = $token->getUser();

        return $this->studentRepository->findOneBy(['associatedUser' => $user->getId()]);
    }

    public function getStudentById(int $id): Student
    {
        return $this->studentRepository->find($id);
    }
}
