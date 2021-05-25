<?php
//*** AGGREGATE HYDRATOR LAB: fill in the missing pieces
namespace Model\Hydrator\Factory;

use Model\Hydrator\ListingsHydrator;
use Laminas\Hydrator\Reflection;
use Laminas\Hydrator\Aggregate\AggregateHydrator;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ListingsHydratorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydroChain = new AggregateHydrator();
        //*** AGGREGATE HYDRATOR LAB: very important: set an event manager instance using the service container
        //***                         this connects the Shared Manager
        $hydroChain->setEventManager($container->get('EventManager'));
        $hydroChain->add(new Reflection());
        $hydroChain->add(new ListingsHydrator());
        return $hydroChain;
        //return new Reflection();
    }
}
