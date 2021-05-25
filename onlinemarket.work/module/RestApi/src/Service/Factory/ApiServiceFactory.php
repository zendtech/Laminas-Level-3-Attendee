<?php
namespace RestApi\Service\Factory;

use RestApi\Service\ApiService;
use Model\Table\ListingsTable;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ApiServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $service = new ApiService();
        $service->setTable($container->get('model-listings-table'));
        return $service;
    }
}
