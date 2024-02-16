<?php
// PATIENTS CONTROLLER

namespace App\Controller;

use App\Entity\Doctors;
use App\Entity\Patients;
use App\Entity\Visits;
use App\Entity\Users;
use App\Repository\PatientsRepository;
use App\Repository\ScheduleRepository;
use App\Repository\VisitsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
class PatientController extends AbstractController
{

    #[Route('/api/patients', name: 'getPatients', methods: ['GET'])]
    public function getPatients(UserInterface $user, ScheduleRepository $scheduleRepository, SerializerInterface $serializer): JsonResponse
    {
        try {
            $doctor = $user->getDoctors();
            $patientsList = $scheduleRepository->findPatientByDoctor($doctor);
            $jsonList = $serializer->serialize($patientsList, 'json', ['groups' => 'getPatients']);

            return new JsonResponse($jsonList, Response::HTTP_OK, [], true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    //For desktop application
    #[Route('/api/patients/{idPatient}/{idVisit}', name: 'getPatient', methods: ['GET'])]
    public function getPatient(UserInterface $user, Request $request, PatientsRepository $patientsRepository, SerializerInterface $serializer): JsonResponse
    {
        try {
            $idPatient = $request->get('idPatient');
            $idVisit = $request->get('idVisit');
            $patientDetails = $patientsRepository->findPatientDetails($idPatient, $idVisit);

            $jsonList = $serializer->serialize($patientDetails, 'json', ['groups' => 'getPatient']);

            return new JsonResponse($jsonList, Response::HTTP_OK, [], true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}