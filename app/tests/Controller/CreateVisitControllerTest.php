<?php

namespace App\Tests\Controller;

use App\Repository\UsersRepository;
use App\Repository\VisitsRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateVisitControllerTest extends WebTestCase
{
    public function testCreateVisitWithLogin()
    {
        $client = static::createClient();

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

        $visitsRepository = static::getContainer()->get(VisitsRepository::class);
        $createdVisit = $visitsRepository->findOneBy([
            'startDate' => new \DateTime('2023-01-01'),
            'EndDate' => new \DateTime('2023-01-02'),
            'reason' => 'Test visit',
            'doctor' => '1',
            'speciality' => '1',
        ]);

        $this->assertNotNull($createdVisit);
    }

    public function testCreateVisitWithoutLogin()
    {
        $client = static::createClient();

        // Créer une nouvelle visite
        $crawler = $client->request('GET', '/create/visit');
        $this->assertSelectorExists('form[name="visits_form"]');

        // Vérifier que le bouton "Valider" a la classe "btn-disabled"
        $submitButton = $crawler->selectButton('Valider');
        $this->assertNotNull($submitButton->attr('disabled'));


    }
}
