<?php

namespace Controller;

use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends AbstractTestController
{
    public function testLoginAction()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'user_1';
        $form['password'] = 'test1234';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
    }
}