<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\PrePersistEventArgs;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doctors $doctor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patients $patient = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTimeBegin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTimeEnd = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPatient(): ?Patients
    {
        return $this->patient;
    }

    public function setPatient(?Patients $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDateTimeBegin(): ?\DateTimeInterface
    {
        return $this->dateTimeBegin;
    }

    public function setDateTimeBegin(\DateTimeInterface $dateTimeBegin): static
    {
        $this->dateTimeBegin = $dateTimeBegin;

        return $this;
    }

    public function getDateTimeEnd(): ?\DateTimeInterface
    {
        return $this->dateTimeEnd;
    }

    public function setDateTimeEnd(\DateTimeInterface $dateTimeEnd): static
    {
        $this->dateTimeEnd = $dateTimeEnd;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function checkMaxPatients(PrePersistEventArgs $eventArgs): void
    {
        $entityManager = $eventArgs->getEntityManager();
        $date = $this->dateTimeBegin->format('Y-m-d');

        $count = $entityManager
            ->getRepository(Schedule::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->where('s.doctor = :doctor')
            ->andWhere('DATE(s.dateTimeBegin) = :date')
            ->setParameter('doctor', $this->doctor)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();

        if ($count >= 5) {
            throw new \Exception('Le médecin a atteint le nombre maximum de patients pour cette journée.');
        }
    }
}
