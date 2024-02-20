<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\MedicationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MedicationsRepository::class)]
class Medications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['postPrescription', 'getPatient'])]
    private ?Drugs $drug = null;

    #[ORM\Column(length: 255)]
    #[Groups(['postPrescription', 'getPatient'])]
    private ?string $dosage = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['postPrescription'])]
    private ?Prescription $prescription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDrug(): ?Drugs
    {
        return $this->drug;
    }

    public function setDrug(Drugs $drug): static
    {
        $this->drug = $drug;

        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): static
    {
        $this->dosage = $dosage;

        return $this;
    }

    public function getPrescription(): ?Prescription
    {
        return $this->prescription;
    }

    public function setPrescription(?Prescription $prescription): static
    {
        $this->prescription = $prescription;

        return $this;
    }


}
