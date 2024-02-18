<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PatientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PatientsRepository::class)]
#[ApiResource]

class Patients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getPatients', 'getVisitsOfDay'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'patients', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getVisitsOfDay' , 'getPatients', 'getPatient'])]
    private ?Users $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getPatient'])]
    private ?string $adress = null;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Visits::class, orphanRemoval: true)]
    #[Groups(['getPatient'])]
    private Collection $visits;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Prescription::class, orphanRemoval: true)]
    #[Groups(['getPatient'])]
    private Collection $prescriptions;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
        $this->prescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection<int, Visits>
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visits $visit): static
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->setPatient($this);
        }

        return $this;
    }

    public function removeVisit(Visits $visit): static
    {
        if ($this->visits->removeElement($visit)) {
            // set the owning side to null (unless already changed)
            if ($visit->getPatient() === $this) {
                $visit->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): static
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions->add($prescription);
            $prescription->setUser($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->prescriptions->removeElement($prescription)) {
            // set the owning side to null (unless already changed)
            if ($prescription->getUser() === $this) {
                $prescription->setUser(null);
            }
        }

        return $this;
    }
}
