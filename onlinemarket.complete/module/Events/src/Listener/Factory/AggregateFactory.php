<?php
namespace Events\Listener\Factory;

use Events\Listener\Aggregate;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $aggregate = new Aggregate($container);
        return $aggregate;
    }
}
