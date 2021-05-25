<?php
namespace AccessControl;

use AccessControl\Listener\AclListenerAggregate;
use Zend\Mvc\MvcEvent;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                AclListenerAggregate::class => function ($container) {
                    $aggregate = new AclListenerAggregate();
                    // inject the ACL & Auth Service
                    $aggregate->setAcl($container->get('access-control-market-acl'));
                    $aggregate->setAuthService($container->get('login-auth-service'));
                    // return the listener aggregate
                    return $aggregate;
                },
            ],
        ];
    }

}
