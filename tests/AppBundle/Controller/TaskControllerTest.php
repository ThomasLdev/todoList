<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DataFixtures\ORM\AppFixtures;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;

class TaskControllerTest extends WebTestCase
{
    private $client = null;
    private $taskName;

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->client = static::createClient();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->taskRepo = $this->em->getRepository(Task::class);
        $this->taskName = 'TestTask'.uniqid();
        $this->loadFixtures([
            AppFixtures::class
        ]);
    }

    public function testUserListAction()
    {
        $this->logIn(false);

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

    // Rajouter les tests admins qui voient les tasks du user anonyme
    // Rajouter un test emptyTask
    // Rajouter les tests de relation task/user une fois implémenté

    public function testUserCreateAction()
    {
        $this->logIn(false);

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

    public function testUserEditAction()
    {
        $this->logIn(false);

        // TODO : activate when user:task relation is up

//        $user = $this->userRepo->findOneBy(["username" => "user_1"]);
//
//        $task = $this->taskRepo->findOneBy([
//            "user_id" => $user->getId()
//        ]);
//        $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/edit');

        $task = $this->taskRepo->findAll()[0];

        $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/edit');

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $this->fillTaskForm($crawler, 'Modifier');

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$task->getTitle().')')->count()
        );
    }

    public function testToggleTaskAction()
    {
        $this->logIn(false);

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Marquer comme faite')->form();
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testDeleteTaskAction()
    {
        $this->logIn(false);

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Supprimer')->form();
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('div.alert.alert-success')->count());
    }

    private function logIn(bool $admin)
    {
        // user_0 is always admin in DataFixtures
        if ($admin){
            $user = "user_0";
        } else {
            $user = "user_1";
        }
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = $user;
        $form['_password'] = 'test1234';
        $this->client->submit($form);
    }

    private function fillTaskForm($crawler, String $formBtn)
    {
        $form = $crawler->selectButton($formBtn)->form();
        $form['task[title]'] = $this->taskName;
        $form['task[content]'] = "Lorem Ipsum";
        $this->client->submit($form);
    }
}