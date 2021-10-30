<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->client = static::createClient();
//        $this->loadFixtures([
//            AppFixtures::class
//        ]);
    }

    public function tearDown()
    {
//        $this->loadFixtures([
//            AppFixtures::class
//        ]);
    }

    public function testLoginAction()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'user_1';
        $form['_password'] = 'test1234';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Bienvenue sur Todo List")')->count()
        );
    }
}