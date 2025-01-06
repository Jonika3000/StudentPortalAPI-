<?php

namespace App\Controller;

use App\Constants\UserRoles;
use App\Entity\Classroom;
use App\Services\ClassroomService;
use App\Services\UserService;
use App\Utils\ExceptionHandleHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ClassroomController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly ClassroomService $classroomService,
    ) {
    }

    #[IsGranted(UserRoles::STUDENT)]
    #[Route('/api/classroom/me', name: 'app_classroom_student', methods: ['GET'])]
    public function getByStudent(): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();

            return new JsonResponse($this->classroomService->getClassroomByStudent($user), Response::HTTP_OK);
        } catch (\Exception $exception) {
            return ExceptionHandleHelper::handleException($exception);
        }
    }

    #[IsGranted(UserRoles::TEACHER)]
    #[Route('/api/classroom/{id}', name: 'app_classroom_teacher', methods: ['GET'])]
    public function getClassroomInfo(Classroom $classroom): JsonResponse
    {
        return new JsonResponse($classroom, Response::HTTP_OK);
    }
}
