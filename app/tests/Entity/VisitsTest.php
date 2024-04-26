<?php

namespace App\Tests\Entity;

use App\Entity\Doctors;
use App\Entity\Patients;
use App\Entity\Specialities;
use App\Entity\Visits;
use PHPUnit\Framework\TestCase;

class VisitsTest extends TestCase
{
    public function testSetAndGetStartDate()
    {
        $visit = new Visits();

        $startDate = new \DateTime('2023-01-01');
        $visit->setStartDate($startDate);

        $this->assertSame($startDate, $visit->getStartDate());
    }

    public function testSetAndGetEndDate()
    {
        $visit = new Visits();

        $endDate = new \DateTime('2024-01-01');
        $visit->setEndDate($endDate);

        $this->assertSame($endDate, $visit->getEndDate());
    }

    public function testSetAndGetReason()
    {
        $visit = new Visits();

        $visit->setReason('Je suis malade');

        $this->assertSame('Je suis malade', $visit->getReason());
    }

    public function testSetAndGetDoctor()
    {
        $visit = new Visits();
        $doctor = new Doctors();

        $visit->setDoctor($doctor);

        $this->assertSame($doctor, $visit->getDoctor());
    }

    public function testSetAndGetPatient()
    {
        $visit = new Visits();
        $patient = new Patients();

        $visit->setPatient($patient);

        $this->assertSame($patient, $visit->getPatient());
    }

    public function testSetAndGetSpeciality()
    {
        $visit = new Visits();
        $speciality = new Specialities();
        $visit->setSpeciality($speciality);
        $this->assertSame($speciality, $visit->getSpeciality());
    }

    public function testCreateVisit()
    {
        $patient = new Patients();
        $doctor = new Doctors();
        $speciality = new Specialities();
        $visit = new Visits();
        $startDate = new \DateTime('2023-01-01');
        $endDate = new \DateTime('2023-01-01');
        $reason = 'Je suis malade';
        $visit->setPatient($patient);
        $visit->setDoctor($doctor);
        $visit->setSpeciality($speciality);
        $visit->setStartDate($startDate);
        $visit->setEndDate($endDate);
        $visit->setReason($reason);
        $this->assertSame($reason, $visit->getReason());
        $this->assertSame($startDate, $visit->getStartDate());
        $this->assertSame($endDate, $visit->getEndDate());
        $this->assertSame($speciality, $visit->getSpeciality());
        $this->assertSame($doctor, $visit->getDoctor());
        $this->assertSame($patient, $visit->getPatient());

    }
}