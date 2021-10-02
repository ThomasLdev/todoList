<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndexAction()
    {
        // Simuler une auth ok
        $this->client->request('GET', '/');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

//    /**
//     * @depends testIndexAction
//     */
//    public function testCreateUserAction()
//    {
//        $this->client->request('GET', '/');
//    }
}
