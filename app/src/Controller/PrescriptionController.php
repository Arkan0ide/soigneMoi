<?php

namespace App\Controller;

use App\Entity\Doctors;
use App\Entity\Drugs;
use App\Entity\Medications;
use App\Entity\Opinions;
use App\Entity\Patients;
use App\Entity\Prescription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
class PrescriptionController extends AbstractController
{
    #[Route('/api/prescription', name: 'postPrescription', methods: ['POST'])]
    public function createPrescription(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, SerializerInterface $serializer): JsonResponse
    {
        try {
            $data = $request->getContent();
            $json = $serializer->deserialize($data, test::class, 'json');
            $errors = $validator->validate($json);
            $prescription = new Prescription();

            $patient = $em->getRepository(Patients::class)->findOneBy(['id' => $json->user]);
            $doctor = $em->getRepository(Doctors::class)->findOneBy(['id' => $json->doctor]);
            $startDate = new \DateTime($json->startDate);
            $endDate = new \DateTime($json->endDate);

            $prescription->setUser($patient);
            $prescription->setDoctor($doctor);
            $prescription->setStartDate($startDate);
            $prescription->setEndDate($endDate);

            $opinion = new Opinions();
            $opinionDate = new \DateTime();

            $opinion->setTitle($json->opinion['title']);
            $opinion->setDate($opinionDate);
            $opinion->setDescription($json->opinion['description']);
            $prescription->setOpinion($opinion);

            // Traitement des médicaments
            foreach ($json->medicationList as $medicationData) {
                $medication = new Medications();
                $drug = $em->getRepository(Drugs::class)->findOneBy(['id' => $medicationData['drug']]);
                $medication->setDrug($drug);
                $medication->setPrescription($prescription);
                $medication->setDosage($medicationData['dosage']);
                $prescription->addMedicationList($medication);
            }
            if (count($errors) > 0) {
                return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
            }
            $em->persist($prescription);
            $em->flush();

            $opinion->setPrescription($prescription);
            $em->persist($opinion);
            $em->flush();
            return new JsonResponse(['status' => 'Prescription created!'], Response::HTTP_CREATED);
        } catch (NotEncodableValueException|UnexpectedValueException $e) {
            return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
class test
{
    public $user;
    public $doctor;
    public $endDate;
    public $startDate;
    public $opinion;
    public $medicationList;
}




