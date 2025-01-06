<?php

namespace App\Controller;

use App\Decoder\FileBagDecoder\UserEditFileBagDecoder;
use App\Decoder\Password\PasswordResetDecoder;
use App\Decoder\Password\PasswordResetRequestDecoder;
use App\Decoder\User\UserEditRequestDecoder;
use App\Request\Password\PasswordResetRequest;
use App\Request\Password\PasswordResetRequestRequest;
use App\Request\User\UserEditRequest;
use App\Services\UserService;
use App\Utils\ExceptionHandleHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly UserService $userService,
    ) {
    }

    #[Route('/user/me', name: 'user', methods: 'GET')]
    public function index(): JsonResponse
    {
        $token = $this->tokenStorage->getToken();

        return $this->json($this->userService->getUserByToken($token));
    }

    #[Route('/password-reset-request', name: 'password_reset_request', methods: ['POST'])]
    public function passwordResetRequest(
        PasswordResetRequestRequest $request,
        PasswordResetRequestDecoder $passwordResetDecoder,
    ): JsonResponse {
        $params = $passwordResetDecoder->decode($request);

        try {
            return new JsonResponse($this->userService->resetPasswordRequest($params->email), Response::HTTP_OK);
        } catch (\Exception $exception) {
            return ExceptionHandleHelper::handleException($exception);
        }
    }

    #[Route('/password-reset', name: 'password_reset', methods: ['POST'])]
    public function passwordReset(
        PasswordResetRequest $request,
        PasswordResetDecoder $passwordResetDecoder,
    ): JsonResponse {
        $params = $passwordResetDecoder->decode($request);
        try {
            return new JsonResponse($this->userService->passwordReset($params->resetToken, $params->newPassword), Response::HTTP_OK);
        } catch (\Exception $exception) {
            return ExceptionHandleHelper::handleException($exception);
        }
    }

    #[Route('/update', name: 'user_update', methods: ['PATCH'])]
    public function userEdit(
        UserEditRequest $request,
        UserEditFileBagDecoder $fileBagDecoder,
        UserEditRequestDecoder $requestDecoder,
    ): JsonResponse {
        try {
            $user = $this->userService->getCurrentUser();
            $files = $fileBagDecoder->decode($request->getFiles());
            $params = $requestDecoder->decode($request);
            $this->userService->editAction($user, $params, $files);

            return new JsonResponse('Success', Response::HTTP_OK);
        } catch (\Exception $exception) {
            return ExceptionHandleHelper::handleException($exception);
        }
    }
}
