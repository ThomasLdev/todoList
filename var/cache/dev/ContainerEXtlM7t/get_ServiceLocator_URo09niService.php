<?php

namespace ContainerEXtlM7t;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_URo09niService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.uRo09ni' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.uRo09ni'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'hasher' => ['privates', 'security.user_password_hasher', 'getSecurity_UserPasswordHasherService', true],
            'user' => ['privates', '.errored..service_locator.uRo09ni.App\\Entity\\User', NULL, 'Cannot autowire service ".service_locator.uRo09ni": it references class "App\\Entity\\User" but no such service exists.'],
        ], [
            'entityManager' => '?',
            'hasher' => '?',
            'user' => 'App\\Entity\\User',
        ]);
    }
}
