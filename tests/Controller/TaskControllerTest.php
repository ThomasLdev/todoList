<?php

namespace Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Tests\Controller\AbstractTestController;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends AbstractTestController
{
    private String $taskName;

    public function setUp(): Void
    {
        parent::setUp();
        $this->taskRepo = $this->entityManager->getRepository(Task::class);
        $this->userRepo = $this->entityManager->getRepository(User::class);
        $this->taskName = 'TestTask'.uniqid();
    }

    public function testUserListAction()
    {
        $this->login($this->client, $this->userRepo->findOneBy(["username" => "user_1"]));

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();

        // col-md-12 = task row, so verify if any task exists
        $this->assertGreaterThan(
            0,
            $crawler->filter('.row .col-md-12')->count()
        );
    }

    public function testAdminListAction()
    {
        $this->login($this->client, $this->userRepo->findOneBy(["username" => "user_0"]));

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();

        // col-md-12 = task row, so verify if any task exists
        $this->assertGreaterThan(
            0,
            $crawler->filter('.row .col-md-12')->count()
        );
    }

    public function testUserCreateAction()
    {
        $this->login($this->client, $this->userRepo->findOneBy(["username" => "user_1"]));
        $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();

//        $this->fillTaskForm($crawler, 'Créer une tâche');
//
//        $crawler = $this->client->followRedirect();
//
//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains('.$this->taskName.')')->count()
//        );
    }

    private function fillTaskForm($crawler, String $formBtn)
    {
        $form = $crawler->selectButton($formBtn)->form();
        $form['task[title]'] = $this->taskName;
        $form['task[content]'] = "Lorem Ipsum";
        $this->client->submit($form);
    }
}