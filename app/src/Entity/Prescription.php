<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PrescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PrescriptionRepository::class)]
class Prescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['postPrescription'])]
    private ?Patients $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['postPrescription'])]
    private ?Doctors $doctor = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['postPrescription'])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['postPrescription'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'prescription', targetEntity: Medications::class, cascade: ['persist', 'remove'])]
    #[Groups(['postPrescription', 'getPatient'])]
    private Collection $MedicationList;

    #[ORM\OneToOne(mappedBy: 'prescription', cascade: ['persist', 'remove'])]
    #[Groups(['getPatient'])]
    private ?Opinions $opinion;

    public function __construct()
    {
        $this->MedicationList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Patients
    {
        return $this->user;
    }

    public function setUser(?Patients $user): static
    {
        $this->user = $user;

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
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Medications>
     */
    public function getMedicationList(): Collection
    {
        return $this->MedicationList;
    }

    public function addMedicationList($medication): static
    {
        if (!$this->MedicationList->contains($medication)) {
            $this->MedicationList->add($medication);
        }

        return $this;
    }

    public function removeMedicationList(Medications $medication): static
    {
        $this->MedicationList->removeElement($medication);
        return $this;
    }

    public function getOpinion()
    {
        return $this->opinion;
    }

    public function setOpinion($opinion): void
    {
        $this->opinion = $opinion;
    }
}


