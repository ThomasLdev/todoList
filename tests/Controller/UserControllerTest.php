<?php

namespace Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends \App\Tests\Controller\AbstractTestController
{
    public function setUp(): Void
    {
        parent::setUp();
        $this->taskRepo = $this->entityManager->getRepository(Task::class);
        $this->userRepo = $this->entityManager->getRepository(User::class);
    }

    public function testAdminListUsersAction()
    {
        $this->login(true);

        $this->client->request('GET', '/users/');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorExists('.table');
    }

    public function testUserTryOnUsersAction()
    {
        $this->login(false);

        $this->client->request('GET', '/users/');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->client->request('GET', '/users/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $user = $this->userRepo->findOneBy(["username" => "user_3"]);
        $this->client->request('GET', '/users/'.$user->getId().'/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAdminCreateUserAction()
    {
        $this->login(true);

        $crawler = $this->client->request('GET', '/users/create');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Save')->form();
        $form['user[username]'] = "user_200";
        $form['user[password][first]'] = "test1234";
        $form['user[password][second]'] = "test1234";
        $form['user[email]'] = "user_200@example.com";
        $form['user[roles]'] = ["ROLE_USER"];
        $this->client->submit($form);

        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.alert.alert-success');

        $this->assertSelectorExists('.table');

        $this->assertNotNull(
            $this->userRepo->findOneBy(['username' => "user_200"])
        );
    }

    public function testAdminEditAction()
    {
        $this->login(true);

        $user = $this->userRepo->findOneBy(["username" => "user_1"]);

        $crawler = $this->client->request('GET', '/users/'.$user->getId().'/edit');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Update')->form();
        $form['user[username]'] = 'nameHasBeenChanged';
        $form['user[password][first]'] = $user->getPassword();
        $form['user[password][second]'] = $user->getPassword();
        $form['user[email]'] = 'emailHasBeenChanged@example.com';
        $form['user[roles]'] = $user->getRoles();
        $this->client->submit($form);

        $this->assertResponseRedirects();
        $crawler = $this->client->followRedirect();

        $this->assertNotNull(
            $this->userRepo->findOneBy(['username' => "nameHasBeenChanged"])
        );

        $this->assertNotNull(
            $this->userRepo->findOneBy(['email' => "emailHasBeenChanged@example.com"])
        );
    }
}