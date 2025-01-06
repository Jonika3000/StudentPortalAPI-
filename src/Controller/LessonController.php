<?php

namespace App\Controller;

use App\Constants\ErrorCodes;
use App\Entity\User;
use App\Services\LessonService;
use App\Services\UserService;
use App\Shared\Response\Exception\IncorrectUserConfigurationException;
use App\Shared\Response\ResponseError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LessonController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly LessonService $lessonService,
    ) {
    }

    #[Route('/api/lesson', name: 'app_lesson')]
    public function getByStudent(): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();
        } catch (IncorrectUserConfigurationException $ex) {
            $response = (new ResponseError())->setCode(ErrorCodes::INCORRECT_USER_CONFIGURATION)->setMessage('User not found');

            return new JsonResponse($response->serializeToJsonString(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($this->lessonService->getLessonsByStudent($user), Response::HTTP_OK);
    }
}
