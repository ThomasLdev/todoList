<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DataFixtures\ORM\AppFixtures;
use AppBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->client = static::createClient();
        $this->loadFixtures([
            AppFixtures::class
        ]);
    }

    public function testGuestIndexAction()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(
            Response::HTTP_FOUND,
            $this->client->getResponse()->getStatusCode()
        );

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('form')->count()
        );
    }

    public function testIndexAction()
    {
        $this->logIn();

        $this->client->request('GET', '/');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    private function logIn()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'user_1';
        $form['_password'] = 'test1234';
        $this->client->submit($form);
    }
}
