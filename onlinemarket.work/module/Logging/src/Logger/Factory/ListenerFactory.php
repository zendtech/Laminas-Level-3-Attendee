<?php
namespace Logging\Logger\Factory;

use Logging\Listener;
use Logging\Logger\Logging;
use Laminas\Log\Writer\ {Stream, FirePhp};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
		$platform = $container->get('model-primary-adapter')->getPlatform();
		$logger   = $container->get(Logging::class);
		return new Listener($logger, $platform);
    }
}
