<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testGetUsername()
    {
        $user = new User();
        $user->setUsername('Roger');

        $result =  $user->getUsername();

        $this->assertSame('Roger', $result);
    }
}