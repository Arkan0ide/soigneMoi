<?php

namespace App\Tests\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateVisitControllerTest extends WebTestCase
{
    public function testCreateVisitWithLogin()
    {
        $client = static::createClient();

        // get or create the user somehow (e.g. creating some users only
        // for tests while loading the test fixtures)
        $userRepository = static::getContainer()->get(UsersRepository::class);
        $testUser = $userRepository->findOneByEmail('patient@soignemoi.com');

        $client->loginUser($testUser);

        // Créer une nouvelle visite
        $crawler = $client->request('GET', '/create/visit');
        $this->assertSelectorExists('form[name="visits_form"]');

        $form = $crawler->selectButton('Valider')->form();

        // Set values for the form fields
        $form['visits_form[startDate]'] = '2023-01-01';
        $form['visits_form[EndDate]'] = '2023-01-02';
        $form['visits_form[reason]'] = 'Test visit';
        $form['visits_form[doctor]'] = '1';
        $form['visits_form[speciality]'] = '1';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/profile'));

        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success', 'Le séjour a été ajouté avec succès.');
    }

//    public function testCreateVisitWithoutLogin()
//    {
//        $client = static::createClient();
//
//        // Créer une nouvelle visite
//        $crawler = $client->request('GET', '/create/visit');
//        $this->assertSelectorExists('form[name="visits_form"]');
//
//        // Vérifier que le bouton "Valider" a la classe "btn-disabled"
//        $submitButton = $crawler->selectButton('Valider');
//        $classes = explode(' ', $submitButton->attr('class'));
//        $this->assertContains('btn:disabled', $classes);
//
//        // Vérifier que le bouton "Valider" est désactivé
//        $this->assertEquals('disabled', $submitButton->attr('disabled'));
//
//    }
}
