<?php

namespace App\Controller;

use App\Repository\VisitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class VisitController extends AbstractController
{
    #[Route('/api/visits', name: 'getVisitsOfDay', methods: ['GET'])]
    public function getVisitsOfDay(UserInterface $user, VisitsRepository $visitsRepository, SerializerInterface $serializer): JsonResponse
    {
        try {

            $visitsList = $visitsRepository->findVisitsOfDay();
            $jsonList = $serializer->serialize($visitsList, 'json', ['groups' => 'getVisitsOfDay']);

            return new JsonResponse($jsonList, Response::HTTP_OK, [], true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
