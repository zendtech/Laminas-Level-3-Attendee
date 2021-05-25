<?php
declare(strict_types=1);
namespace Manage\Domain;

use Psr\Container\ContainerInterface;

class ListingsServiceFactory
{
    public function __invoke(ContainerInterface $container) : ListingsService
    {
        return new ListingsService($container);
    }
}
