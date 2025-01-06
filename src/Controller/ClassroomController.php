<?php

namespace App\Controller;

use App\Constants\ErrorCodes;
use App\Constants\UserRoles;
use App\Services\ClassroomService;
use App\Services\UserService;
use App\Shared\Response\Exception\IncorrectUserConfigurationException;
use App\Shared\Response\ResponseError;
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
    #[Route('/api/lesson', name: 'app_lesson')]
    public function getByStudent(): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();
        } catch (IncorrectUserConfigurationException) {
            $response = (new ResponseError())->setCode(ErrorCodes::INCORRECT_USER_CONFIGURATION)->setMessage('User not found');

            return new JsonResponse($response->serializeToJsonString(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($this->classroomService->getClassroomByStudent($user), Response::HTTP_OK);
    }
}
