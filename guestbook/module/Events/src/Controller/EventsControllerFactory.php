<?php
namespace Events\Controller;

use Events\TableModule\Model\EventTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Events\Controller\ConsoleController;

class ConsoleControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ConsoleController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ConsoleController($container->get(EventTable::class));
    }
}
