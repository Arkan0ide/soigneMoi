<?php

namespace App\Tests\Controller;

use App\Entity\Users;
use App\Repository\PatientsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{

    public function testLogout()
    {
        $client = static::createClient();

        $client->request('GET', '/logout');

        $this->assertTrue($client->getResponse()->isRedirect());
    }



    public function testLoginRedirectsToUserProfileWhenLoggedInAsPatient()
    {

//        $client = static::createClient();
//        $patientRepository = static::getContainer()->get(PatientsRepository::class);
//
//        // Trouve le patient test
//        $testPatient = $patientRepository->findPatientByEmail('patient@soignemoi.com');
//
//        // Simule sa connexion
//        $client->loginUser($testPatient->getUser());
//
//        // Test la redirection sur /profile
//        $client->request('GET', '/profile');
//        $this->assertResponseIsSuccessful();
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UsersRepository::class);
        $testUser = $userRepository->findOneByEmail('patient@soignemoi.com');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/profile');
        $this->assertResponseIsSuccessful();

    }

//    public function testLoginDisplaysErrorWhenLoggedInWithWrongUser()
//    {
//        $client = static::createClient();
//
//        // Créer un utilisateur avec des identifiants qui n'existent pas dans la base de données
//        $user = new Users();
//        $user->setEmail('unknownEmail@soignemoi.com');
//        $user->setPassword('unknownPassword');
//
//        // Simuler une tentative de connexion avec cet utilisateur
//        $client->loginUser($user);
//
//        // Faire une requête GET sur la page de profil
//        $client->request('GET', '/profile');
//
//        // Vérifier que la réponse est une redirection vers la page de connexion
//        $this->assertResponseRedirects('/login');
//        $this->assert
//
//
//    }


}