<?php
namespace Logging\Logger\Factory;

use Logging\Logger\Logging;
use Zend\Log\Writer\ {Stream, FirePhp};
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
		$writerStream = new Stream($container->get('logging-error-log-filename'));
		$writerFirePhp = new FirePhp();
		$logger = new Logging();
		$logger->addWriter($writerStream);
		$logger->addWriter($writerFirePhp);
		return $logger;
    }
}
