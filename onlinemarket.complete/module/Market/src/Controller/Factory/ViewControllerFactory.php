<?php
//*** this factory will no longer be needed after the initializer has been created
namespace Market\Controller\Factory;

use Market\Controller\ViewController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ViewControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new ViewController();
        //** the following line can be removed once the initializer has been created
        //$controller->setListingsTable($container->get('model-listings-table'));
        return $controller;
    }
}
