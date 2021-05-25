<?php
namespace Registration\Controller\Factory;

use Registration\Form\RegForm;
use Registration\Controller\RegController;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;


class RegControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new RegController();
        $controller->setTable($container->get('model-users-table'));
        $controller->setRegForm($container->get(RegForm::class));
        return $controller;
    }
}
