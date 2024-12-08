<?php

namespace App\Controller;

use App\Decoder\FileBagDecoder\UserEditFileBagDecoder;
use App\Decoder\Password\PasswordResetDecoder;
use App\Decoder\Password\PasswordResetRequestDecoder;
use App\Decoder\User\UserEditRequestDecoder;
use App\Entity\User;
use App\Request\Password\PasswordResetRequest;
use App\Request\Password\PasswordResetRequestRequest;
use App\Request\User\UserEditRequest;
use App\Services\UserService;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly UserService $userService,
    ) {
    }

    #[Route('/api/user/me', name: 'app_user', methods: 'GET')]
    public function index(): JsonResponse
    {
        $token = $this->tokenStorage->getToken();

        return $this->json($this->userService->getUserByToken($token));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws RandomException
     */
    #[Route('/api/password-reset-request', name: 'app_password_reset_request', methods: ['POST'])]
    public function passwordResetRequest(
        PasswordResetRequestRequest $request,
        PasswordResetRequestDecoder $passwordResetDecoder,
    ): JsonResponse {
        $params = $passwordResetDecoder->decode($request);

        return new JsonResponse($this->userService->resetPasswordRequest($params->email), 200);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/api/password-reset', name: 'app_password_reset', methods: ['POST'])]
    public function passwordReset(
        PasswordResetRequest $request,
        PasswordResetDecoder $passwordResetDecoder,
    ): JsonResponse {
        $params = $passwordResetDecoder->decode($request);

        return new JsonResponse($this->userService->passwordReset($params->resetToken, $params->newPassword), 200);
    }

    /**
     * @throws \Exception
     */
    #[Route('/api/update', name: 'app_user_update', methods: ['PATCH'])]
    public function userEdit(
        UserEditRequest $request,
        UserEditFileBagDecoder $fileBagDecoder,
        UserEditRequestDecoder $requestDecoder,
    ): JsonResponse {
        $token = $this->tokenStorage->getToken();
        $files = $fileBagDecoder->decode($request->getFiles());
        $params = $requestDecoder->decode($request);
        $user = $this->userService->getUserByToken($token);

        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        $this->userService->editAction($user, $params, $files);

        return new JsonResponse('Success', 200);
    }
}
