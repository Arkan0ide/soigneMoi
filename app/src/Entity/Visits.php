<?php

namespace App\Entity;

use App\Repository\VisitsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitsRepository::class)]
class Visits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patients $patient = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $EndDate = null;

    #[ORM\Column(length: 255)]
    private ?string $reason = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doctors $doctor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialities $speciality = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patients
    {
        return $this->patient;
    }

    public function setPatient(?Patients $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->EndDate;
    }

    public function setEndDate(\DateTimeInterface $EndDate): static
    {
        $this->EndDate = $EndDate;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getDoctor(): ?Doctors
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctors $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getSpeciality(): ?Specialities
    {
        return $this->speciality;
    }

    public function setSpeciality(?Specialities $speciality): static
    {
        $this->speciality = $speciality;

        return $this;
    }
}
