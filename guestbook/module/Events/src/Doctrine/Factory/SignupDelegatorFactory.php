<?php
namespace Events\Doctrine\Factory;

use Exception;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

class SignupDelegatorFactory implements DelegatorFactoryInterface
{

    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        array $options = null)
    {
        $controller = $callback();
        $controller->setFilter($container->get('events-doctrine-data-filter'));
        return $controller;
    }
}
