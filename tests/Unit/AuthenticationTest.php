<?php

// tests/AuthenticationTest.php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationTest extends WebTestCase
{
   
    public function testSuccessfulAuthentication()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login'); // Înlocuiți '/login' cu URL-ul real al paginii de autentificare

        $form = $crawler->selectButton('Sign In')->form();
        $form['email'] = 'email@email.com'; // Înlocuiți cu numele de utilizator corect
        $form['password'] = 'parola'; // Înlocuiți cu parola corectă

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
