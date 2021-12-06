<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends AbstractTestController
{
    public function testGuestIndexAction()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(
            Response::HTTP_FOUND,
            $this->client->getResponse()->getStatusCode()
        );

        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('form')->count()
        );
    }

    public function testIndexAction()
    {
        $this->login(false);

        $this->client->request('GET', '/');
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }
}