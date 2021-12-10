<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractTestController extends WebTestCase
{
    protected AbstractDatabaseTool $databaseTool;
    protected ?KernelBrowser $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->databaseTool = $this->client
            ->getContainer()
            ->get(DatabaseToolCollection::class)
            ->get();
        $this->databaseTool->loadFixtures([
            'App\DataFixtures\AppFixtures'
        ]);
    }

    protected function login(bool $admin)
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        // user_0 = admin
        $form['username'] = ($admin) ? "user_0" : "user_1";
        $form['password'] = 'test1234';
        $this->client->submit($form);
    }
}