<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $birthdate;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Enrollment::class)]
    private Collection $enrollments;

    public function __construct()
    {
        $this->enrollments = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function getBirthdate(): ?\DateTimeInterface { return $this->birthdate; }
    public function setBirthdate(\DateTimeInterface $birthdate): self { $this->birthdate = $birthdate; return $this; }
    public function getEnrollments(): Collection { return $this->enrollments; }
}
