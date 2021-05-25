<?php
//*** this factory will no longer be needed after the initializer has been created
namespace Market\Controller\Factory;

use Market\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new IndexController();
        //** the following line can be removed once the initializer has been created
        //$controller->setListingsTable($container->get('model-listings-table'));
        return $controller;
    }
}
