<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    /**
     * @param ObjectManager $manager
     * @codeCoverageIgnore
     */
    public function load(ObjectManager $manager)
    {
        // Create 4 regular users and 1 admin
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user_' . $i);
            $password = $this->container->get('security.password_encoder')->encodePassword($user, 'test1234');
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
                $task->setUser($user);
                $manager->persist($task);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}