<?php
declare(strict_types=1);
namespace Admin\Domain;

use Psr\Container\ContainerInterface;

class ServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        return new $requestedName($container);
    }
}
