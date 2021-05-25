<?php
namespace IpCheck;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    // specify ip address to block in /config/autoload/ip.check.local.php
    'service_manager' => [
        'services' => [
            'ip-check-config' => [
                // if neither white nor black lists are defined, all are allowed
                // if both white-list and black-list are defined, only entries on white-list are allowed
                // if only black-list is defined, entries are denied, all others allowed
                // if only white-list is defined, any entries are allowed, all others denied
                'black-list' => [],
                'white-list' => [],
                'redirect'   => [
                    'controller' => \Application\Controller\IndexController::class,
                    'action' => 'index',
                ],
            ],
        ],
    ],
    // specify routes to override in /config/autoload/ip.check.local.php
    /*
    'router' => [
        'routes' => [
            'ip-check-restricted' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/restricted',
                    'defaults' => [
                        'middleware' => [Middleware\LogIp::class, Middleware\BlockIp::class],
                    ],
                ],
            ],
        ],
    ],
    */
];
