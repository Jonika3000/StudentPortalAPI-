<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->userService->createNewUser($data);

        return $this->json(['message' => 'Registered Successfully']);
    }
}
