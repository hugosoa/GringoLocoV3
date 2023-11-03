<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testRightLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Veuillez-vous connecter');

        $submitButton = $crawler->selectButton('Se connecter');
        $form = $submitButton->form();

        $form["email"] = "test@mail.com";
        $form["password"] = "123456";

        $client->submit($form);

        $this->assertResponseRedirects('/profil');
    }
}
