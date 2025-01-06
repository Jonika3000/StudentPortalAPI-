<?php

namespace App\Services;

use App\Entity\Homework;
use App\Entity\HomeworkFile;
use App\Entity\User;
use App\Params\FilesParams\HomeworkFilesParams;
use App\Params\Homework\HomeworkPostParams;
use App\Repository\HomeworkFileRepository;
use App\Repository\HomeworkRepository;
use App\Repository\LessonRepository;
use App\Repository\TeacherRepository;
use App\Shared\Response\Exception\Lesson\LessonNotFound;
use App\Shared\Response\Exception\Teacher\TeacherNotFoundException;
use App\Shared\Response\Exception\User\AccessDeniedException;
use App\Utils\FileHelper;
use Symfony\Component\Uid\Uuid;

class HomeworkService
{
    public function __construct(
        private readonly TeacherRepository      $teacherRepository,
        private readonly LessonRepository       $lessonRepository,
        private readonly HomeworkRepository     $homeworkRepository,
        private readonly FileHelper             $fileHelper,
        private readonly HomeworkFileRepository $homeworkFileRepository,
    ) {
    }

    /**
     * @throws TeacherNotFoundException
     * @throws LessonNotFound
     * @throws AccessDeniedException
     */
    public function postAction(HomeworkPostParams $params, User $user, ?HomeworkFilesParams $files = null): array
    {
        $teacher = $this->teacherRepository->findOneBy(['associatedUser' => $user->getId()]);
        if (!$teacher) {
            throw new TeacherNotFoundException();
        }

        $lesson = $this->lessonRepository->find($params->lesson);
        if (!$lesson) {
            throw new LessonNotFound();
        }
        $isTeacherAssignedToLesson = $teacher->getLesson()->contains($lesson);

        if (!$isTeacherAssignedToLesson) {
            throw new AccessDeniedException();
        }

        $homework = new Homework();
        $homework->setTeacher($teacher);
        $homework->setLesson($lesson);
        $homework->setDescription($params->description);
        $homework->setDeadline($params->deadline);

        if ($files) {
            foreach ($files->files as $file) {
                $homeworkFile = new HomeworkFile();
                $homeworkFile->setHomework($homework);
                $filePath = $this->fileHelper->uploadFile($file, '/files/homework/', false);
                $homeworkFile->setPath($filePath);
                $homeworkFile->setName(Uuid::v1());

                $this->homeworkFileRepository->save($homeworkFile);
            }
        }

        $this->homeworkRepository->seveHomework($homework);

        return ['message' => 'Success.'];
    }
}
