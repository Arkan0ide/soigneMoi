<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Form\ScheduleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleAdminController extends AbstractController
{
    #[Route('/admin/schedule', name: 'app_admin_schedule')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $schedule = new Schedule();
        $scheduleForm = $this->createForm(ScheduleFormType::class, $schedule);
        $scheduleForm->handleRequest($request);
        if ($scheduleForm->isSubmitted() && $scheduleForm->isValid()) {
            try {
                $entityManager->persist($schedule);
                $entityManager->flush();
                return $this->redirectToRoute('app_home_page');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('schedule_admin/index.html.twig', [
            'scheduleForm' => $scheduleForm->createView()
        ]);
    }
}
