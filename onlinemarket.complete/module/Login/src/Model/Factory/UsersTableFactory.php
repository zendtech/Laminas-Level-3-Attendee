<?php
namespace Login\Model\Factory;

use Model\Entity\User;
use Login\Model\UsersTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Hydrator\ClassMethods;

class UsersTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new UsersTable($container->get('login-db-adapter'), new User(), new ClassMethods());
    }
}
