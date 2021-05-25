<?php
namespace AccessControl\Acl\Factory;

use AccessControl\Acl\GuestbookAcl;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class GuestbookAclFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $config = $container->get('Config')['access-control-config'];
        $acl = new GuestbookAcl($config, $container);
        return $acl;
    }
}
