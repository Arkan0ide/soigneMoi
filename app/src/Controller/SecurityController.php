<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_profile');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(Request $request,
                             JWTTokenManagerInterface $jwtManager, UsersRepository $usersRepository): JsonResponse
    {
        // Récupérer les données d'identification envoyées par l'application ElectronJS
        $data = json_decode($request->getContent(), true);
        $email = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        // Trouver l'utilisateur correspondant à l'e-mail
        $user = $usersRepository->findOneBy(['email' => $email]);
//        $passwordHasher = $this->container->get('security.password_hasher');
        // Vérifier les identifiants de l'utilisateur
        if (!$user || !password_verify($password, $user->getPassword())) {
            throw new AuthenticationException('Identifiants invalides');
        }

        $token = $jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
