<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getPatients'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getPatients'])]
    private ?Doctors $doctor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getPatients'])]
    private ?Patients $patient = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['getPatients'])]
    private ?\DateTimeInterface $dateTimeBegin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['getPatients'])]
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
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $eventArgs->getObjectManager();

        $scheduleDate = $this->getDateTimeBegin()->format('Y-m-d');
        $doctor = $this->getDoctor();

        $existingSchedulesCount = $entityManager->getRepository(Schedule::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->where('s.doctor = :doctor')
            ->andWhere('s.dateTimeBegin BETWEEN :dateStart AND :dateEnd')
            ->setParameter('doctor', $doctor)
            ->setParameter('dateStart', $scheduleDate . ' 00:00:00')
            ->setParameter('dateEnd', $scheduleDate . ' 23:59:59')
            ->getQuery()
            ->getSingleScalarResult();

        if ($existingSchedulesCount >= 5) {
            throw new \Exception('Le médecin ne peut pas avoir plus de 5 patients programmés pour la même journée.');
        }
    }
}
