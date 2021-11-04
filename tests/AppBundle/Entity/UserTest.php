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

    public function testSetId()
    {
        $user = new User();
        $user->setId(1);

        $result =  $user->getId();

        $this->assertSame(1, $result);
    }
}