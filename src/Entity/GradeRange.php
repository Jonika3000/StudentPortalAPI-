<?php

namespace App\Entity;

use App\Repository\GradeRangeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GradeRangeRepository::class)]
class GradeRange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Type('integer')]
    #[Assert\GreaterThanOrEqual(0, message: 'The maximum grade must be a non-negative number.')]
    private ?int $max = null;

    #[ORM\Column]
    #[Assert\Type('integer')]
    #[Assert\GreaterThanOrEqual(0, message: 'The minimum grade must be a non-negative number.')]
    #[Assert\Expression(
        'this.getMin() <= this.getMax()',
        message: 'The minimum grade must be less than or equal to the maximum grade.'
    )]
    private ?int $min = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(int $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(int $min): static
    {
        $this->min = $min;

        return $this;
    }
}
