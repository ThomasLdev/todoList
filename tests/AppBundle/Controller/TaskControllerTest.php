<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    private $client = null;
    private $taskName;
    private $taskContent;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->taskName = 'TestTask'.uniqid();
        $this->taskContent = 'Lorem ipsum.';

    }

    public function testListAction()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        // col-md-12 = task row, so verify if any task exists
        $this->assertGreaterThan(
            0,
            $crawler->filter('.row .col-md-12')->count()
        );
    }

    public function testCreateAction()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $this->fillTaskForm($crawler, 'Ajouter');

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$this->taskName.')')->count()
        );
    }

    public function testEditAction()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tasks/3/edit');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $this->fillTaskForm($crawler, 'Modifier');

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$this->taskName.')')->count()
        );
    }

    public function testToggleTaskAction()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Marquer comme faite')->form();
        $this->client->submit($form);

        // LE FLASH N'APPARAIT PAS DONC VOIR COMMENT VERIF L'ACTION
//        $this->assertGreaterThan(0, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testDeleteTaskAction()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Supprimer')->form();
        $this->client->submit($form);

        // LE FLASH N'APPARAIT PAS DONC VOIR COMMENT VERIF L'ACTION
//        $this->assertGreaterThan(0, $crawler->filter('div.alert.alert-success')->count());
    }

    private function logIn()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'ThomasLdev';
        $form['_password'] = 'test12345';
        $this->client->submit($form);
    }

    private function fillTaskForm($crawler, String $formBtn)
    {
        $form = $crawler->selectButton($formBtn)->form();
        $form['task[title]'] = $this->taskName;
        $form['task[content]'] = $this->taskContent;
        $this->client->submit($form);
    }
}