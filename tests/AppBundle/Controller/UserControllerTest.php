<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private $client = null;
    private $username;
    private $email;
    private $password;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->username = 'TestUser'.time();
        $this->email = 'test-'.uniqid().'@example.com';
        $this->password = 'test12345';
    }

    public function testListAction()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/users');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('table')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Actions")')->count()
        );
    }

    public function testCreateAction()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = $this->username;
        $form['user[password][first]'] = $this->password;
        $form['user[password][second]'] = $this->password;
        $form['user[email]'] = $this->email;
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('table')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$this->username.')')->count()
        );
    }

    public function testEditAction()
    {
        $crawler = $this->client->request('GET', '/users/2/edit');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = $this->username;
        $form['user[password][first]'] = $this->password;
        $form['user[password][second]'] = $this->password;
        $form['user[email]'] = $this->email;
        $this->client->submit($form);

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