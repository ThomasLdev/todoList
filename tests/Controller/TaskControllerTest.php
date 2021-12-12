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

    public function testUserListTasksAction()
    {
        $this->login(false);

        $crawler = $this->client->request('GET', '/tasks/');
        $this->assertResponseIsSuccessful();

        // col-md-12 = task row, so verify if any task exists
        $this->assertGreaterThan(
            0,
            $crawler->filter('.row .col-md-12')->count()
        );
    }

    public function testAdminListTasksAction()
    {
        $this->login(true);

        $crawler = $this->client->request('GET', '/tasks/');
        $this->assertResponseIsSuccessful();

        // col-md-12 = task row, so verify if any task exists
        $this->assertGreaterThan(
            0,
            $crawler->filter('.row .col-md-12')->count()
        );
    }

    public function testUserCreateTaskAction()
    {
        $this->login(false);
        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();

        $this->fillTaskForm($crawler, 'Valider');

        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$this->taskName.')')->count()
        );
    }

    public function testAdminCreateTaskAction()
    {
        $this->login(true);
        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseIsSuccessful();

        $taskName = 'task0';
        $this->fillTaskForm($crawler, 'Valider');

        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$taskName.')')->count()
        );
    }

    public function testUserEditTaskAction()
    {
        $this->login(false);

        $user = $this->userRepo->findOneBy(["username" => "user_1"]);

        $task = $this->taskRepo->findOneBy([
            "user" => $user
        ]);

        $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/edit');

        $this->assertResponseIsSuccessful();

        $this->fillTaskForm($crawler, 'Valider');

        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('.$this->taskName.')')->count()
        );
    }

    public function testUserFailEditTaskAction()
    {
        $this->login(false);

        // get another user than the task author
        $user = $this->userRepo->findOneBy(["username" => "user_2"]);

        $task = $this->taskRepo->findOneBy([
            "user" => $user
        ]);

        $this->client->request('GET', '/tasks/'.$task->getId().'/edit');

        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testUserToggleTaskAction()
    {
        $this->login(false);

        $crawler = $this->client->request('GET', '/tasks/');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Marquer comme faite')->form();
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('div.alert.alert-success')->count());

        $crawler = $this->client->request('GET', '/tasks/done');
        $this->assertResponseIsSuccessful();

        $this->assertEquals(6, $crawler->filter('.thumbnail')->count());
    }

    public function testUserFailToggleTaskAction()
    {
        $this->login(false);

        // get another user than the task author
        $user = $this->userRepo->findOneBy(["username" => "user_2"]);

        $task = $this->taskRepo->findOneBy([
            "user" => $user
        ]);

        $this->client->request('GET', '/tasks/'.$task->getId().'/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testUserDeleteTaskAction()
    {
        $this->login(false);

        $crawler = $this->client->request('GET', '/tasks/');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Supprimer')->form();
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertGreaterThan(0, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testUserFailDeleteTaskAction()
    {
        $this->login(false);

        $user = $this->userRepo->findOneBy(["username" => "user_2"]);

        $task = $this->taskRepo->findOneBy([
            "user" => $user
        ]);

        $this->client->request('GET', '/tasks/'.$task->getId().'/delete');

        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
    }

    private function fillTaskForm($crawler, $btn)
    {
        $form = $crawler->selectButton($btn)->form();
        $form['task[title]'] = $this->taskName;
        $form['task[content]'] = "Lorem Ipsum";
        $this->client->submit($form);
    }
}