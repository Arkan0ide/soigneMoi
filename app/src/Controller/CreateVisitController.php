<?php

namespace App\Controller;

use App\Entity\Visits;
use App\Form\VisitsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateVisitController extends AbstractController
{
    #[Route('/create/visit', name: 'app_create_visit')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $visit = new Visits();
        $visitForm = $this->createForm(VisitsFormType::class, $visit);
        $visitForm->handleRequest($request);

        if ($visitForm->isSubmitted() && $visitForm->isValid()) {
            $visit->setPatient($this->getUser()->getPatients());
            $entityManager->persist($visit);
            $entityManager->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('create_visit/index.html.twig', [
            'visitForm' => $visitForm->createView()
        ]);
    }
}
