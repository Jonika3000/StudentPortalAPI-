<?php

namespace App\Services;

use App\Entity\Grade;
use App\Entity\User;
use App\Params\Grade\GradePostParams;
use App\Repository\GradeRepository;
use App\Repository\StudentSubmissionRepository;
use App\Repository\TeacherRepository;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class GradeService
{
    public function __construct(
        private readonly GradeRepository               $gradeRepository,
        private readonly StudentSubmissionRepository   $studentSubmissionRepository,
        private readonly TeacherRepository             $teacherRepository,
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    //@TODO: errors handle
    public function postAction(User $user, GradePostParams $params): string
    {
        $studentSubmission = $this->studentSubmissionRepository->find($params->studentSubmission);
        if (!$studentSubmission) {
            return 'Student submission not found.';
        }

        $teacher = $this->teacherRepository->findOneBy(['associatedUser' => $user->getId()]);
        if (!$teacher) {
            return 'Teacher not found.';
        }

        if (!$this->authorizationChecker->isGranted('grade', $studentSubmission)) {
            return 'Access denied: Teacher is not associated with this lesson.';
        }

        $existingGrade = $this->gradeRepository->findOneBy(['studentSubmission' => $studentSubmission]);
        $grade = $existingGrade ?? new Grade();

        $grade->setGrade($params->grade)
            ->setComment($params->comment)
            ->setStudentSubmission($studentSubmission)
            ->setTeacher($teacher);

        $this->gradeRepository->saveGrade($grade);

        return 'Success';
    }
}
