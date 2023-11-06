<?php

use Symfony\Component\Panther\PantherTestCase;

class RegistrationTest extends PantherTestCase
{
    public function testRegistration()
    {
        $client = self::createPantherClient();
        $crawler = $client->request('GET', '/register'); // Înlocuiți '/register' cu URL-ul real al paginii de înregistrare

        $form = $crawler->selectButton('Register')->form();
        $form['email'] = 'testuser@example.com'; // Setați o adresă de email unică
        $form['plainPassword'] = 'Daniel01'; // Setați o parolă sigură

        $client->submit($form);

        $this->assertSelectorTextContains('div.flash-message', 'Registration successful.'); // Înlocuiți textul cu mesajul real de succes de înregistrare
    }
}
