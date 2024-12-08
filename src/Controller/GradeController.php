<?php

namespace App\Controller;

use App\Constants\UserRoles;
use App\Decoder\Grade\GradePostDecoder;
use App\Entity\User;
use App\Request\Grade\GradePostRequest;
use App\Services\GradeService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GradeController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly GradeService $gradeService,
        private readonly UserService $userService,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[IsGranted(UserRoles::TEACHER)]
    #[Route('/api/grade', name: 'app_grade', methods: ['POST'])]
    public function index(GradePostRequest $request, GradePostDecoder $decoder): JsonResponse
    {
        $token = $this->tokenStorage->getToken();
        $user = $this->userService->getUserByToken($token);
        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        $params = $decoder->decode($request);

        return new JsonResponse($this->gradeService->postAction($user, $params), 200);
    }
}
