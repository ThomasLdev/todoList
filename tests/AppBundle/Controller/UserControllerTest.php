<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\DataFixtures\ORM\AppFixtures;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use AppBundle\Entity\User;

class UserControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->client = static::createClient();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->userRepo = $this->em->getRepository(User::class);

        $this->loadFixtures([
            AppFixtures::class
        ]);
    }

    public function testAdminListAction()
    {
        // log into the app
        $this->logIn(true);

        $crawler = $this->client->request('GET', '/users');

        // are access rights ok
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        // is the html present
        $this->assertGreaterThan(
            0,
            $crawler->filter('table')->count()
        );

        // are the cols present
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Actions")')->count()
        );

        // are users present
        $this->assertEquals(
            1,
            $crawler->filter('html:contains("user_0")')->count()
        );
    }

    public function testUserListAction()
    {
        // log into the app
        $this->logIn(false);

        $this->client->request('GET', '/users');

        // are access rights forbidden
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testAdminCreateAction()
    {
        // log into the app
        $this->logIn(true);

        $crawler = $this->client->request('GET', '/users/create');

        // are access rights ok
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        // fill the form
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = "user_200";
        $form['user[password][first]'] = "test1234";
        $form['user[password][second]'] = "test1234";
        $form['user[email]'] = "user_200@example.com";
        $form['user[roles]'] = ["ROLE_USER"];
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        // is listAction html present
        $this->assertGreaterThan(
            0,
            $crawler->filter('table')->count()
        );

        // is created user present
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains(user_200)')->count()
        );
    }

    public function testUserCreateAction()
    {
        // log into the app
        $this->logIn(false);

        $this->client->request('GET', '/users/create');

        // are access rights forbidden
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
    }

    public function testAdminEditAction()
    {
        // log into the app
        $this->logIn(true);

        $user = $this->userRepo->findOneBy(["username" => "user_1"]);

        $crawler = $this->client->request('GET', '/users/'.$user->getId().'/edit');

        // are access rights ok
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        // fill the form
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'nameHasBeenChanged';
        $form['user[password][first]'] = $user->getPassword();
        $form['user[password][second]'] = $user->getPassword();
        $form['user[email]'] = 'emailHasBeenChanged@example.com';
        $form['user[roles]'] = $user->getRoles();
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        // is changed username present
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("nameHasBeenChanged")')->count()
        );

        // is changed email present
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("emailHasBeenChanged@example.com")')->count()
        );
    }

    public function testUserEditAction()
    {
        // log into the app
        $this->logIn(false);

        $user = $this->userRepo->findOneBy(["username" => "user_1"]);

        $this->client->request('GET', '/users/'.$user->getId().'/edit');

        // are access rights forbidden
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $this->client->getResponse()->getStatusCode()
        );
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
}