<?php
namespace Registration\Controller\Factory;

use Registration\Form\RegForm;
use Registration\Controller\RegController;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class RegControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new RegController();
        //*** FORMS LAB: inject the table and form classes into the controller
        $controller->setTable($container->get('model-users-table'));
        $controller->setRegForm($container->get(RegForm::class));
        return $controller;
    }
}
