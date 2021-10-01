<?php

namespace Tests\AppBundle\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Method;
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
        $this->client->request('GET', '/');
        $this->assertEquals(
            Response::HTTP_FOUND,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * @depends testIndexAction
     */
    public function testRedirectToLoginAction()
    {
        $this->client->request('GET', '/');
    }

    public function testCreateUserAction()
    {
        //TODO
    }
}
