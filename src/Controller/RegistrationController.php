<?php

namespace App\Controller;

use App\Decoder\RegisterRequestDecoder;
use App\Request\RegisterRequest;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly RegisterRequestDecoder $registerRequestDecoder,
    ) {
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    public function index(RegisterRequest $request): JsonResponse
    {
        $params = $this->registerRequestDecoder->decode($request);
        $this->userService->postAction($params);

        return $this->json(['message' => 'Registered Successfully']);
    }
}
