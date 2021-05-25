<?php
namespace Guestbook\Listener\Factory;

use Guestbook\Listener\CacheAggregate;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CacheAggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $aggregate = new CacheAggregate();
        $aggregate->setCacheAdapter($container->get('cache-adapter'));
        return $aggregate;
    }
}
