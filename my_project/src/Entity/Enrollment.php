<?php

namespace App\Entity;

use App\Repository\EnrollmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnrollmentRepository::class)]
class Enrollment {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'enrollments')]
    private ?Student $student = null;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'enrollments')]
    private ?Course $course = null;

    #[ORM\OneToOne(mappedBy: 'enrollment', targetEntity: Grade::class, cascade: ['persist', 'remove'])]
    private ?Grade $grade = null;

    public function getId(): ?int { return $this->id; }
    public function getStudent(): ?Student { return $this->student; }
    public function setStudent(?Student $student): self { $this->student = $student; return $this; }
    public function getCourse(): ?Course { return $this->course; }
    public function setCourse(?Course $course): self { $this->course = $course; return $this; }
    public function getGrade(): ?Grade { return $this->grade; }
    public function setGrade(?Grade $grade): self { $this->grade = $grade; return $this; }
}
