<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'float')]
    private float $score;

    #[ORM\OneToOne(inversedBy: 'grade', targetEntity: Enrollment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Enrollment $enrollment;

    public function getId(): ?int { return $this->id; }
    public function getScore(): ?float { return $this->score; }
    public function setScore(float $score): self { $this->score = $score; return $this; }
    public function getEnrollment(): ?Enrollment { return $this->enrollment; }
    public function setEnrollment(Enrollment $enrollment): self { $this->enrollment = $enrollment; return $this; }
}
