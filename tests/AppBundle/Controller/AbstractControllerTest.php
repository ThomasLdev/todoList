<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    private $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = $this->client = static::createClient();
    }

    public function getAuthenticatedUser(bool $admin): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = ($admin) ? "user_0" : "user_1";
        $form['_password'] = 'test1234';
        $this->client->submit($form);
    }
}