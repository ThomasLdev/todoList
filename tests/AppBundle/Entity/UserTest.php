<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;

class UserTest extends TestCase
{
//    public function setUp()
//    {
//        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
//        $this->taskRepo = $this->em->getRepository(Task::class);
//        $this->userRepo = $this->em->getRepository(User::class);
//        $this->loadFixtures([
//            AppFixtures::class
//        ]);
//    }

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

//    public function testGetTasks()
//    {
//        $user = $this->userRepo->findOneBy(["username" => "user_1"]);
//
//
//    }
//
//    public function testSetTasks()
//    {
//        $user = new User();
//        $task[] = new Task();
//        $user->setTasks($task);
//
//        $this->assertSame($task, $user->getTasks());
//    }
}