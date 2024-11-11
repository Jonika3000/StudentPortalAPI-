<?php

namespace App\Entity;

use App\Repository\StudentSubmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentSubmissionRepository::class)]
class StudentSubmission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $submittedDate = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'studentSubmissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Homework $homework = null;

    /**
     * @var Collection<int, StudentSubmissionFile>
     */
    #[ORM\OneToMany(targetEntity: StudentSubmissionFile::class, mappedBy: 'studentSubmission')]
    private Collection $studentSubmissionFiles;

    #[ORM\OneToOne(mappedBy: 'studentSubmission', cascade: ['persist', 'remove'])]
    private ?Grade $grade = null;

    public function __construct()
    {
        $this->studentSubmissionFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubmittedDate(): ?\DateTimeInterface
    {
        return $this->submittedDate;
    }

    public function setSubmittedDate(\DateTimeInterface $submittedDate): static
    {
        $this->submittedDate = $submittedDate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getHomework(): ?Homework
    {
        return $this->homework;
    }

    public function setHomework(?Homework $homework): static
    {
        $this->homework = $homework;

        return $this;
    }

    /**
     * @return Collection<int, StudentSubmissionFile>
     */
    public function getStudentSubmissionFiles(): Collection
    {
        return $this->studentSubmissionFiles;
    }

    public function addStudentSubmissionFile(StudentSubmissionFile $studentSubmissionFile): static
    {
        if (!$this->studentSubmissionFiles->contains($studentSubmissionFile)) {
            $this->studentSubmissionFiles->add($studentSubmissionFile);
            $studentSubmissionFile->setStudentSubmission($this);
        }

        return $this;
    }

    public function removeStudentSubmissionFile(StudentSubmissionFile $studentSubmissionFile): static
    {
        if ($this->studentSubmissionFiles->removeElement($studentSubmissionFile)) {
            // set the owning side to null (unless already changed)
            if ($studentSubmissionFile->getStudentSubmission() === $this) {
                $studentSubmissionFile->setStudentSubmission(null);
            }
        }

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(Grade $grade): static
    {
        // set the owning side of the relation if necessary
        if ($grade->getStudentSubmission() !== $this) {
            $grade->setStudentSubmission($this);
        }

        $this->grade = $grade;

        return $this;
    }
}
