<?php

namespace Controller;

use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends AbstractTestController
{
    public function testUserLoginAction()
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

    public function testAdminLoginAction()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'user_0';
        $form['password'] = 'test1234';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testBadLoginAction()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'badcredentials';
        $form['password'] = 'nevermind';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertGreaterThan(
            0,
            $crawler->filter('.alert-danger')->count()
        );
    }
}