<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageControllerTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Nos services');

        // Vérifie la présence d'une spécialité
        $this->assertCount(
            1,
            $crawler->filter('.speciality-icon + div',),
            'Aucune spécialité trouvée sur la page d\'accueil'
        );

    }
}
