<?php

namespace App\Controller;

use App\Repository\DrugsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DrugsController extends AbstractController
{
    #[Route('/api/drugs', name: 'getDrugs', methods: ['GET'])]
        public function getDrugs(UserInterface $user, DrugsRepository $drugsRepository, SerializerInterface $serializer): JsonResponse
        {
            try {
                $drugsList = $drugsRepository->findAll();
                $jsonList = $serializer->serialize($drugsList, 'json', ['groups' => 'getDrugs']);

                return new JsonResponse($jsonList, Response::HTTP_OK, [], true);
            } catch (\Exception $e) {
                return new JsonResponse(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    }
}
