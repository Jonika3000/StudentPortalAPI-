<?php

namespace App\Controller;

use App\Decoder\PasswordResetDecoder;
use App\Request\PasswordResetRequest;
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
    #[Route('/password-reset-request', name: 'password_reset_request', methods: ['POST'])]
    public function passwordResetRequest(
        PasswordResetRequest $request,
        PasswordResetDecoder $passwordResetDecoder,
    ): JsonResponse {
        $params = $passwordResetDecoder->decode($request);

        return $this->userService->resetPasswordRequest($params->email);
    }
}
