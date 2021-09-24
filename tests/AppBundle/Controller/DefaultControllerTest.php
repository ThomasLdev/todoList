<?php

namespace Tests\AppBundle\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
}
