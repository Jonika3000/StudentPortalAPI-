<?php

namespace App\Controller;

use App\Constants\ErrorCodes;
use App\Constants\UserRoles;
use App\Decoder\Grade\GradePostDecoder;
use App\Entity\Grade;
use App\Request\Grade\GradePostRequest;
use App\Services\GradeService;
use App\Services\UserService;
use App\Shared\Response\Exception\IncorrectUserConfigurationException;
use App\Shared\Response\ResponseError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GradeController extends AbstractController
{
    public function __construct(
        private readonly GradeService $gradeService,
        private readonly UserService $userService,
    ) {
    }

    #[IsGranted(UserRoles::TEACHER)]
    #[Route('/api/grade', name: 'app_grade_post', methods: ['POST'])]
    public function post(GradePostRequest $request, GradePostDecoder $decoder): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();
        } catch (IncorrectUserConfigurationException) {
            $response = (new ResponseError())->setCode(ErrorCodes::INCORRECT_USER_CONFIGURATION)->setMessage('User not found');

            return new JsonResponse($response->serializeToJsonString(), Response::HTTP_BAD_REQUEST);
        }

        $params = $decoder->decode($request);

        return new JsonResponse($this->gradeService->postAction($user, $params), 200);
    }

    #[IsGranted(UserRoles::TEACHER)]
    #[Route('/api/grade/{id}', name: 'app_grade_delete', methods: ['DELETE'])]
    public function remove(Grade $grade): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();
        } catch (IncorrectUserConfigurationException) {
            $response = (new ResponseError())->setCode(ErrorCodes::INCORRECT_USER_CONFIGURATION)->setMessage('User not found');

            return new JsonResponse($response->serializeToJsonString(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($this->gradeService->deleteAction($user, $grade), 200);
    }
}
