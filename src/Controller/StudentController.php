<?php

namespace App\Controller;

use App\Constants\UserRoles;
use App\Entity\Student;
use App\Services\StudentService;
use App\Services\UserService;
use App\Utils\ExceptionHandleHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class StudentController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly StudentService $studentService,
    ) {
    }

    #[Route('/api/student/me', name: 'app_student_me', methods: 'GET')]
    public function index(): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();

            return new JsonResponse($this->studentService->getStudentByUser($user), Response::HTTP_OK);
        } catch (\Exception $exception) {
            return ExceptionHandleHelper::handleException($exception);
        }
    }

    #[IsGranted(UserRoles::TEACHER)]
    #[Route('/api/student/{id}', name: 'app_student_get', methods: 'GET')]
    public function find(Student $student): JsonResponse
    {
        return new JsonResponse($student, Response::HTTP_OK);
    }
}
