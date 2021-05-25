<?php
namespace Model\Table\Factory;

use Model\Entity\User;
use Model\Table\UsersTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;

class UsersTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UsersTable($container->get('model-primary-adapter'), new User(), new ClassMethods());
    }
}
