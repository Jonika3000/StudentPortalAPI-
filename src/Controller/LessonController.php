<?php

namespace App\Controller;

use App\Services\LessonService;
use App\Services\UserService;
use App\Utils\ExceptionHandleHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class LessonController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly LessonService $lessonService,
    ) {
    }

    #[Route('/lesson', name: 'lesson')]
    public function getByStudent(): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();

            return new JsonResponse($this->lessonService->getLessonsByStudent($user), Response::HTTP_OK);
        } catch (\Exception $exception) {
            return ExceptionHandleHelper::handleException($exception);
        }
    }
}
