<?php

namespace App\Shared\Response\StudentSubmission;

class StudentSubmissionResponse
{
    public function __construct(
        public int $id,
        public string $submittedDate,
        public string $comment,
        public $grade,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'submittedDate' => $this->submittedDate,
            'comment' => $this->comment,
            'grade' => $this->grade,
        ];
    }
}
