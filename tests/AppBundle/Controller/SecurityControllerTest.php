<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testLoginTrueAction()
    {
        $credentials = [
            'username' => 'ThomasLdev',
            'password' => 'test12345'
        ];
// Find how to test redirection in phpunit 5.7
//        $this->post('login', $credentials)->assertRedirect('/');
    }
}