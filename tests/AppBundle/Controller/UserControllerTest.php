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
    private $roles;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->username = 'TestUser'.time();
        $this->email = 'test-'.uniqid().'@example.com';
        $this->password = 'test1234';
        $this->roles = 'ROLE_USER';
    }

    public function testAdminListAction()
    {
        // LOAD FIXTURES

        // LIST_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(true);

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

        // RELOAD FIXTURES
    }

    public function testUserListAction()
    {
        // LOAD FIXTURES

        // LIST_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(false);

        $this->client->request('GET', '/users');
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );

        // RELOAD FIXTURES
    }

    public function testAdminCreateAction()
    {
        // LOAD FIXTURES

        // CREATE_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(true);

        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = $this->username;
        $form['user[password][first]'] = $this->pasword;
        $form['user[password][second]'] = $this->password;
        $form['user[email]'] = $this->email;
        $form['user[roles]'] = $this->roles;
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        // Test that there is a page
        $this->assertGreaterThan(
            0,
            $crawler->filter('table')->count()
        );

        // Test that the username is present in the list
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$this->username.')')->count()
        );

        // RELOAD FIXTURES
    }

    public function testUserCreateAction()
    {
        // LOAD FIXTURES

        // CREATE_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(false);

        $this->client->request('GET', '/users/create');
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );

        // RELOAD FIXTURES
    }

    public function testAdminEditAction()
    {
        // LOAD FIXTURES

        // CREATE_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(true);

        $crawler = $this->client->request('GET', '/users/3/edit');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'nameHasBeenChanged';
        $form['user[password][first]'] = $this->password;
        $form['user[password][second]'] = $this->password;
        $form['user[email]'] = 'emailHasBeenChanged@example.com';
        $form['user[roles]'] = $this->roles;
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        // Test that the new username is present in the list
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("nameHasBeenChanged")')->count()
        );

        // Test that the new email is present in the list
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("emailHasBeenChanged@example.com")')->count()
        );

        // RELOAD FIXTURES
    }

    public function testUserEditAction()
    {
        // LOAD FIXTURES

        // CREATE_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(false);

        $crawler = $this->client->request('GET', '/users/3/edit');
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );

        // RELOAD FIXTURES
    }

    private function logIn(bool $admin)
    {
        // USER 1 IS ADMIN, REST IS USER, PASSWORD IS ALWAYS THE SAME
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = $admin = true ? 'user_1' : 'user_2';
        $form['_password'] = 'test1234';
        $this->client->submit($form);
    }
}