<?php
namespace Model\Table\Factory;

use Model\Table\CityCodesTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CityCodesTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CityCodesTable(CityCodesTable::TABLE_NAME, $container->get('model-primary-adapter'));
    }
}
