<?php

namespace App\Controller;

use App\Decoder\FileBagDecoder\RegisterFileBagDecoder;
use App\Decoder\User\RegisterRequestDecoder;
use App\Request\User\RegisterRequest;
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
        private readonly RegisterFileBagDecoder $registerFileBagDecoder,
    ) {
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    public function index(RegisterRequest $request): JsonResponse
    {
        $files = $this->registerFileBagDecoder->decode($request->getFiles());
        $params = $this->registerRequestDecoder->decode($request);
        $this->userService->postAction($params, $files);

        return $this->json(['message' => 'Registered Successfully']);
    }
}
