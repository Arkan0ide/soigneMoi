<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Doctors;
use App\Entity\Patients;
use App\Form\DoctorType;
use App\Form\PatientType;
use App\Form\RegistrationFormType;
use App\Security\Authenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    #[Route('/admin', name: 'app_admin')]  // Nouvelle route pour les admins
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $route = $request->attributes->get('_route');

        if($route == 'app_admin'){
            $doctor = new Doctors();
            $form = $this->createForm(DoctorType::class, $doctor);
        }else if($route == 'app_register'){
            $patient = new Patients();
            $form = $this->createForm(PatientType::class, $patient);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Users();
            $user->setEmail($form->get('user')->get('email')->getData());
            $user->setFirstname($form->get('user')->get('firstname')->getData());
            $user->setLastname($form->get('user')->get('lastname')->getData());
            if($route == 'app_admin'){
                $user->setDoctors($doctor);
                $user->setRoles(['ROLE_DOCTOR']);
            }else if($route == 'app_register'){
                $user->setPatients($patient);
                $user->setRoles(['ROLE_PATIENT']);
            }
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('user')->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            if($route == 'app_register'){
                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'route' => $route,
        ]);
    }
}
