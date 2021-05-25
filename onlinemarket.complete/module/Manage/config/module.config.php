<?php
namespace Manage;

use Laminas\Router\Http\ {Literal, Segment};
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    //*** make sure you add the appropriate ACL configuration (see below)
    'navigation' => [
        'default' => [
            'manage' => ['label' => 'Manage', 'route' => 'manage', 'resource' => 'menu-manage']
        ]
    ],
    'router' => [
        'routes' => [
            'manage' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/manage',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'lookup' => [
                        //*** define a route to a middleware pipe
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/lookup[/:id]',
                            'defaults' => [
                                'middleware' => [Middleware\Log::class, Middleware\Lookup::class],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'access-control-config' => [
        'resources' => [
            'manage'      => 'Manage\Controller\IndexController',
            'menu-manage' => 'menu-manage',
        ],
        //*** uncomment and add the appropriate rights assignments for "admin"
        'rights' => [
            'admin' => [
                'manage'      => ['allow' => NULL],
                'menu-manage' => ['allow' => NULL],
            ],
        ],
    ],
];
