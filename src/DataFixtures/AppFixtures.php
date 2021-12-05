<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create 4 regular users and 1 admin
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user_' . $i);
            $password = $this->hasher->hashPassword($user, "test1234");
            $user->setPassword($password);
            $user->setEmail('user_' . $i . '@example.com');
            $i == 0 ? $user->setRoles(['ROLE_ADMIN']) : $user->setRoles(['ROLE_USER']);
            // Create 10 tasks per user
            for ($b = 0; $b < 10; $b++) {
                $task = new Task();
                $task->setTitle('task' . $b);
                $task->setContent('test content' . $b);
                // 1 task on 2 is done
                $b % 2 == 1 ? $task->toggle(true) : $task->toggle(false);
                $i == 0 ? : $task->setUser($user);
                $manager->persist($task);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}
