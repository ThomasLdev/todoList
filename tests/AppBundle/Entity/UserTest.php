<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\User;

class UserTest extends TestCase
{
    public function testGetUsername()
    {
        $user = new User();
        $user->setUsername('Roger');

        $result =  $user->getUsername();

        $this->assertSame('Roger', $result);
    }
}