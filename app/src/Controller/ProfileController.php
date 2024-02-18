<?php

namespace App\Controller;

use App\Entity\Visits;
use App\Form\VisitsFormType;
use App\Repository\VisitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(VisitsRepository $visitsRepository): Response
    {

        $user = $this->getUser();
        $patient = $user->getPatients();

        if($user) {
            $visits = $visitsRepository->findBy(['patient' => $patient], ['startDate' => 'ASC']);        }

        return $this->render('profile/index.html.twig', [
            'visits' => $visits
        ]);
    }
}
