<?php
namespace AccessControl\Assertion\Factory;

use DateTime;
use InvalidArgumentException;
use AccessControl\Assertion\DateTimeAssert;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class DateTimeAssertFactory implements FactoryInterface
{
    const ERROR_CONFIG = 'ERROR: missing config key "access-control-config => assertions => date-time-assert-config"';
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $config = $container->get('Config')['access-control-config']['assertions']['date-time-assert-config'] ?? FALSE;
        if (!$config) throw new InvalidArgumentException(self::ERROR_CONFIG);

        $start = new DateTime();
        $start->setTime($config['start']['hour'], $config['start']['minute'], $config['start']['second']);
        $stop = new DateTime();
        $stop->setTime($config['stop']['hour'], $config['start']['minute'], $config['start']['second']);
        $assert = new DateTimeAssert($start, $stop);
        return $assert;

    }
}
