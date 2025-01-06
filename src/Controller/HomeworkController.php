<?php

namespace App\Controller;

use App\Constants\UserRoles;
use App\Decoder\FileBagDecoder\HomeworkFileBagDecoder;
use App\Decoder\Homework\HomeworkPostDecoder;
use App\Entity\Homework;
use App\Request\Homework\HomeworkPostRequest;
use App\Services\HomeworkService;
use App\Services\UserService;
use App\Utils\ExceptionHandleHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api', name: 'api_')]
class HomeworkController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly HomeworkService $homeworkService,
        private readonly HomeworkFileBagDecoder $fileBagDecoder,
        private readonly HomeworkPostDecoder $paramsDecoder,
    ) {
    }

    #[Route('/homework', name: 'app_homework')]
    public function index(): Response
    {
        return $this->render('homework/index.html.twig', [
            'controller_name' => 'HomeworkController',
        ]);
    }

    #[IsGranted(UserRoles::TEACHER)]
    #[Route('/homework', name: 'homework', methods: ['POST'])]
    public function store(HomeworkPostRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->getCurrentUser();
            $params = $this->paramsDecoder->decode($request);
            $files = $this->fileBagDecoder->decode($request->getFiles());

            return new JsonResponse($this->homeworkService->postAction($params, $user, $files), Response::HTTP_OK);
        } catch (\Exception $exception) {
            return ExceptionHandleHelper::handleException($exception);
        }
    }

    #[Route('/homework/{id}', name: 'homework_get_by_id', methods: ['GET'])]
    public function view(Homework $homework): JsonResponse
    {
        return new JsonResponse($homework, Response::HTTP_OK);
    }
}
