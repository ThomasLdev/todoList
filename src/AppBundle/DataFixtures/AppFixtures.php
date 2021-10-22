<?php

namespace App\DataFixtures;

use App\AppBundle\Entity\Task;
use App\AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create 5 users
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user_' . $i);
            $password = $this->get('security.password_encoder')->encodePassword($user, 'test1234');
            $user->setPassword($password);
            $user->setEmail('user_' . $i . '@example.com');
            $i == 1 ? $user->setRole('ROLE_ADMIN') : $user->setRole('ROLE_USER');

            // Create 10 tasks per user
            for ($i = 0; $i < 10; $i++) {
                $task = new Task();
                $task->setTitle('task' . $i);
                $task->setContent('test content' . $i);
                // 1 task on 2 is done
                $i % 2 == 1 ? $task->setIsDone(true) : $task->setIsDone(false);
//                TODO :
//                $task->setUser($user);
                $manager->persist($task);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}