<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndexAction()
    {
        // TEST 1 : Log in with test user
        $this->logIn();

        // TEST 2 : Get homepage = 200
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    private function logIn()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'ThomasLdev';
        $form['_password'] = 'test12345';
        $this->client->submit($form);
    }
}
