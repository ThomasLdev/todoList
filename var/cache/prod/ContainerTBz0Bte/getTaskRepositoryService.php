<?php

namespace ContainerTBz0Bte;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getTaskRepositoryService extends App_KernelProdContainer
{
    /*
     * Gets the private 'App\Repository\TaskRepository' shared autowired service.
     *
     * @return \App\Repository\TaskRepository
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['App\\Repository\\TaskRepository'] = new \App\Repository\TaskRepository(($container->services['doctrine'] ?? $container->getDoctrineService()));
    }
}
