<?php

namespace Tests\AppBundle\Entity;

use DateTime;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Task;

class TaskTest extends TestCase
{
    public function testGetCreatedAt()
    {
        $task = new Task();

        $result =  $task->getCreatedAt();

        $this->assertSame($task->getCreatedAt(), $result);
    }

    public function testSetCreatedAt()
    {
        $task = new Task();

        $date = new DateTime('now');

        $task->setCreatedAt($date);

        $result =  $task->getCreatedAt($date);

        $this->assertSame($date, $result);
    }
}