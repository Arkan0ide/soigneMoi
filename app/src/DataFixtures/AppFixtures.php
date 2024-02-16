<?php

namespace App\DataFixtures;

use App\Entity\Doctors;
use App\Entity\Drugs;
use App\Entity\Medications;
use App\Entity\Opinions;
use App\Entity\Patients;
use App\Entity\Prescription;
use App\Entity\Schedule;
use App\Entity\Specialities;
use App\Entity\Users;
use App\Entity\Visits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $usersData = [
            [1, 'admin@soignemoi.com', '["ROLE_ADMIN"]', 'admin', 'Admin', 'Soignemoi'],
            [2, 'secretariat@soignemoi.com', '["ROLE_SECRETARIAT"]', 'secretariat', 'Secrétariat', 'Soignemoi'],
            [3, 'louis@soignemoi.com', '["ROLE_PATIENT"]', 'louis', 'Louis', 'XIII'],
            [4, 'bernard@soignemoi.com', '["ROLE_PATIENT"]', 'bernard', 'Bernard', 'Clavel'],
            [5, 'claude@soignemoi.com', '["ROLE_PATIENT"]', 'claude', 'Claude', 'Ponti'],
            [6, 'robert@soignemoi.com', '["ROLE_PATIENT"]', 'robert', 'Robert', 'Schuman'],
            [7, 'house@soignemoi.com', '["ROLE_DOCTOR"]', 'house', 'Docteur', 'House'],
            [8, 'cymes@soignemoi.com', '["ROLE_DOCTOR"]', 'cymes', 'Docteur', 'Cymes'],
            [9, 'carpentier@soignemoi.com', '["ROLE_DOCTOR"]', 'carpentier', 'Docteur', 'Carpentier'],
            [10, 'pasteur@soignemoi.com', '["ROLE_DOCTOR"]', 'pasteur', 'Docteur', 'Pasteur']
        ];

        foreach ($usersData as $userData) {
            $user = new Users();
            $user->setEmail($userData[1]);
            $user->setRoles(json_decode($userData[2]));
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData[3]));
            $user->setFirstname($userData[4]);
            $user->setLastname($userData[5]);
            $manager->persist($user);
        }
        

        $patientsData = [
            [1, 3, '1 rue de la Paix'],
            [2, 4, '2 rue de la Poste'],
            [3, 5, '3 rue du Commerce'],
            [4, 6, '4 rue de l\'Eglise']
        ];

        foreach ($patientsData as $patientData) {
            $patient = new Patients();
            $patient->setUser($manager->getReference(Users::class, $patientData[1]));
            $patient->setAdress($patientData[2]);
            $manager->persist($patient);
        }


        $specialitiesData = [
            ['Médecine général'],
            ['Cardiologie'],
            ['Psychiatrie']
        ];

        foreach ($specialitiesData as $specialityData) {
            $speciality = new Specialities();
            $speciality->setName($specialityData[0]);
            $manager->persist($speciality);
        }

        $doctorsData = [
            [7, 1, '123456'],
            [8, 1, '654321'],
            [9, 2, '789012'],
            [10, 3, '321654']
        ];

        foreach ($doctorsData as $doctorData) {
            $doctor = new Doctors();
            $doctor->setUser($manager->getReference(Users::class, $doctorData[0]));
            $doctor->setSpeciality($manager->getReference(Specialities::class, $doctorData[1]));
            $doctor->setRegistrationNumber($doctorData[2]);
            $manager->persist($doctor);
        }

        $drugsData = [
            ['Doliprane'],
            ['Paracétamol'],
            ['Ibuprofène'],
            ['Amoxicilline'],
            ['Placébo']
        ];

        foreach ($drugsData as $drugData) {
            $drug = new Drugs();
            $drug->setName($drugData[0]);
            $manager->persist($drug);
        }



        $prescriptionsData = [
            [1, 1, 1, '2024-02-15', '2024-02-22'],
            [2, 2, 2, '2024-02-16', '2024-02-23'],
            [3, 2, 2, '2024-02-01', '2024-02-15'],
            [4, 3, 3, '2024-02-05', '2024-02-12'],
            [5, 3, 3, '2024-01-25', '2024-02-01'],
            [6, 3, 3, '2023-12-20', '2023-12-27'],
            [7, 4, 4, '2024-02-10', '2024-02-17']
        ];

        foreach ($prescriptionsData as $prescriptionData) {
            $prescription = new Prescription();
            $prescription->setUser($manager->getReference(Patients::class, $prescriptionData[1]));
            $prescription->setDoctor($manager->getReference(Doctors::class, $prescriptionData[2]));
            $prescription->setStartDate(new \DateTime($prescriptionData[3]));
            $prescription->setEndDate(new \DateTime($prescriptionData[4]));
            $manager->persist($prescription);
        }

        $opinionsData = [
            [1, 'Avis positif', '2024-02-20', 'Efficacité et bien-être ressentis.'],
            [2, 'Maux de tête', '2024-02-22', 'Nausées et maux de tête.'],
            [3, 'Phase terminale', '2024-02-10', 'Le patient est dans le coma'],
            [4, 'RAS', '2024-02-07', 'RAS'],
            [5, 'Sortie', '2024-02-01', 'Patient guérie'],
            [6, 'Entrée du patient', '2023-12-20', 'Douleur cranienne'],
            [7, 'Effets secondaires', '2024-02-15', 'Nausées et maux de tête.']
        ];

        foreach ($opinionsData as $opinionData) {
            $opinion = new Opinions();
            $opinion->setPrescription($manager->getReference(Prescription::class, $opinionData[0]));
            $opinion->setTitle($opinionData[1]);
            $opinion->setDate(new \DateTime($opinionData[2]));
            $opinion->setDescription($opinionData[3]);
            $manager->persist($opinion);
        }


        $medicationsData = [
            [1, 1, 1, '1000mg'],
            [2, 2, 3, '500mg'],
            [3, 3, 2, '200mg'],
            [4, 4, 3, '500mg'],
            [5, 5, 5, '250mg'],
            [6, 1, 6, '500mg'],
            [7, 2, 6, '1000mg'],
            [8, 3, 6, '200mg'],
            [9, 4, 7, '500mg'],
            [10, 5, 7, '250mg']
        ];

        foreach ($medicationsData as $medicationData) {
            $medication = new Medications();
            $medication->setDrug($manager->getReference(Drugs::class, $medicationData[1]));
            $medication->setPrescription($manager->getReference(Prescription::class, $medicationData[2]));
            $medication->setDosage($medicationData[3]);
            $manager->persist($medication);
        }

        $visitsData = [
            [1, 1, 1, '2024-02-15', '2024-02-15', 'Consultation générale'],
            [1, 2, 1, '2024-02-01', '2024-02-01', 'Contrôle cardiologique'],
            [2, 1, 1, '2024-02-10', '2024-02-10', 'Consultation générale'],
            [2, 3, 2, '2024-02-05', '2024-02-05', 'Suivi psychiatrique'],
            [3, 1, 1, '2024-02-08', '2024-02-08', 'Consultation générale'],
            [4, 4, 3, '2024-02-12', '2024-02-12', 'Vaccination'],
            [1, 1, 1, '2024-02-22', '2024-02-22', 'Suivi post-opératoire'],
            [2, 1, 1, '2024-02-17', '2024-02-17', 'Consultation générale'],
            [3, 1, 2, '2024-02-15', '2024-02-15', 'Douleur cardiaque'],
            [4, 4, 3, '2024-02-19', '2024-02-19', 'Rappel de vaccin']
        ];

        foreach ($visitsData as $visitData) {
            $visit = new Visits();
            $visit->setPatient($manager->getReference(Patients::class, $visitData[0]));
            $visit->setDoctor($manager->getReference(Doctors::class, $visitData[1]));
            $visit->setSpeciality($manager->getReference(Specialities::class, $visitData[2]));
            $visit->setStartDate(new \DateTime($visitData[3]));
            $visit->setEndDate(new \DateTime($visitData[4]));
            $visit->setReason($visitData[5]);
            $manager->persist($visit);
        }

        $scheduleData = [
            [1, 1, '2024-02-29T09:00:00', '2024-02-29T10:00:00'],
            [1, 2, '2024-03-15T09:00:00', '2024-03-15T10:00:00'],
            [2, 3, '2024-02-24T10:00:00', '2024-02-24T11:00:00'],
            [3, 4, '2024-03-01T14:00:00', '2024-03-01T15:00:00'],
            [4, 1, '2024-03-08T10:00:00', '2024-03-08T11:00:00']
        ];

        foreach ($scheduleData as $scheduleItem) {
            $schedule = new Schedule();
            $schedule->setDoctor($manager->getReference(Doctors::class, $scheduleItem[0]));
            $schedule->setPatient($manager->getReference(Patients::class, $scheduleItem[1]));
            $schedule->setDateTimeBegin(new \DateTime($scheduleItem[2]));
            $schedule->setDateTimeEnd(new \DateTime($scheduleItem[3]));
            $manager->persist($schedule);
        }

        $manager->flush();
    }
}
