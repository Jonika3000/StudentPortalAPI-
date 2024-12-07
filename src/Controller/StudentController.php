<?php

namespace App\Controller;

use App\Constants\UserRoles;
use App\Services\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class StudentController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly StudentService $studentService,
    ) {
    }

    #[Route('/api/student/me', name: 'app_student', methods: 'GET')]
    public function index(): JsonResponse
    {
        $token = $this->tokenStorage->getToken();

        return $this->json($this->studentService->getStudentByToken($token));
    }

    #[IsGranted(UserRoles::TEACHER)]
    #[Route('/api/student/{id}', name: 'app_student', methods: 'GET')]
    public function find($id): JsonResponse
    {
        return $this->json($this->studentService->getStudentById($id));
    }
}
