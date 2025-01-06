<?php

namespace App\Services;

use App\Entity\Grade;
use App\Entity\User;
use App\Params\Grade\GradePostParams;
use App\Repository\GradeRepository;
use App\Repository\StudentSubmissionRepository;
use App\Repository\TeacherRepository;
use App\Shared\Response\Exception\Student\StudentSubmissionNotFound;
use App\Shared\Response\Exception\Teacher\TeacherNotFoundException;
use App\Shared\Response\Exception\User\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class GradeService extends AbstractController
{
    public function __construct(
        private readonly GradeRepository $gradeRepository,
        private readonly StudentSubmissionRepository $studentSubmissionRepository,
        private readonly TeacherRepository $teacherRepository,
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    /**
     * @throws StudentSubmissionNotFound
     * @throws TeacherNotFoundException
     * @throws AccessDeniedException
     */
    public function postAction(User $user, GradePostParams $params): void
    {
        $studentSubmission = $this->studentSubmissionRepository->find($params->studentSubmission);
        if (!$studentSubmission) {
            throw new StudentSubmissionNotFound();
        }

        $teacher = $this->teacherRepository->findOneBy(['associatedUser' => $user->getId()]);
        if (!$teacher) {
            throw new TeacherNotFoundException();
        }

        if (!$this->authorizationChecker->isGranted('grade', $studentSubmission)) {
            throw new AccessDeniedException();
        }

        $existingGrade = $this->gradeRepository->findOneBy(['studentSubmission' => $studentSubmission]);
        $grade = $existingGrade ?? new Grade();

        $grade->setGrade($params->grade)
            ->setComment($params->comment)
            ->setStudentSubmission($studentSubmission)
            ->setTeacher($teacher);

        $this->gradeRepository->saveGrade($grade);
    }

    /**
     * @throws TeacherNotFoundException
     * @throws AccessDeniedException
     */
    public function deleteAction(User $user, Grade $grade): void
    {
        $teacher = $this->teacherRepository->findOneBy(['associatedUser' => $user->getId()]);
        if (!$teacher) {
            throw new TeacherNotFoundException();
        }

        if ($teacher->getId() != $grade->getTeacher()->getId()) {
            throw new AccessDeniedException();
        }

        $this->gradeRepository->deleteGrade($grade);
    }
}
