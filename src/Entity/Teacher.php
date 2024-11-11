<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $associatedUser = null;

    /**
     * @var Collection<int, Homework>
     */
    #[ORM\OneToMany(targetEntity: Homework::class, mappedBy: 'teacher')]
    private Collection $homework;

    /**
     * @var Collection<int, Lesson>
     */
    #[ORM\OneToMany(targetEntity: Lesson::class, mappedBy: 'teachers')]
    private Collection $lessons;

    public function __construct()
    {
        $this->homework = new ArrayCollection();
        $this->lessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssociatedUser(): ?User
    {
        return $this->associatedUser;
    }

    public function setAssociatedUser(User $associatedUser): static
    {
        $this->associatedUser = $associatedUser;

        return $this;
    }

    /**
     * @return Collection<int, Homework>
     */
    public function getHomework(): Collection
    {
        return $this->homework;
    }

    public function addHomework(Homework $homework): static
    {
        if (!$this->homework->contains($homework)) {
            $this->homework->add($homework);
            $homework->setTeacher($this);
        }

        return $this;
    }

    public function removeHomework(Homework $homework): static
    {
        if ($this->homework->removeElement($homework)) {
            // set the owning side to null (unless already changed)
            if ($homework->getTeacher() === $this) {
                $homework->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): static
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
            $lesson->setTeachers($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): static
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getTeachers() === $this) {
                $lesson->setTeachers(null);
            }
        }

        return $this;
    }
}
