<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}
