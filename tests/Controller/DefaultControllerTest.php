<?php

use App\DataFixtures\AppFixtures;
use App\Test\Controller\AbstractControllerTest;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp(): Void
    {
        parent::setUp();
        self::bootKernel();
        $this->client = static::createClient();
        $this->loadFixtures([
            AppFixtures::class
        ]);
    }
}