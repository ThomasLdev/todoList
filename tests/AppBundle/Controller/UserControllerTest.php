<?php

namespace Tests\AppBundle\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
    {
//        // Set up a dummy client for tests
        $this->client = static::createClient();

        // Load clean fixtures for each test
//        $loader = new Loader();
//        $loader->loadFromDirectory('src/AppBundle/DataFixtures/ORM');
//        $purger = new ORMPurger();
//        $executor = new ORMExecutor($em, $purger);
//        $executor->execute($loader->getFixtures(), true);
        $kernel = self::bootKernel();
        $this->addFixture
    }

    public function testAdminListAction()
    {
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
    }

    public function testUserListAction()
    {
        // LIST_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(false);

        $this->client->request('GET', '/users');
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testAdminCreateAction()
    {
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
    }

    public function testUserCreateAction()
    {
        // CREATE_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(false);

        $this->client->request('GET', '/users/create');
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testAdminEditAction()
    {
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
    }

    public function testUserEditAction()
    {
        // CREATE_ACTION IS ONLY ACCESSIBLE BY ADMIN
        $this->logIn(false);

        $crawler = $this->client->request('GET', '/users/3/edit');
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
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