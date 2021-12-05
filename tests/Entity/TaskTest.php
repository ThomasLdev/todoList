<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
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

        $date = new DateTimeImmutable('now');

        $task->setCreatedAt($date);

        $result =  $task->getCreatedAt($date);

        $this->assertSame($date, $result);
    }
}