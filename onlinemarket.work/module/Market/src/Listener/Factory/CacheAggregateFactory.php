<?php
namespace Market\Listener\Factory;

use Market\Listener\CacheAggregate;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CacheAggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $aggregate = new CacheAggregate();
        $aggregate->setServiceContainer($container);
        return $aggregate;
    }
}
