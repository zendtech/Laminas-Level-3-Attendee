<?php
namespace PrivateMessages;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\I18n\View\Helper\DateFormat;

return [
    'navigation' => [
        'default' => [
            'messages' => ['label' => 'Messages', 'route' => 'messages', 'resource' => 'menu-messages']
        ]
    ],
    'router' => [
        'routes' => [
            'messages' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/messages[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'keypairs' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/keypairs[/:action]',
                    'defaults' => [
                        'controller' => Controller\KeypairsController::class,
                        'action'     => 'diffie',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Form\Send::class => Form\Factory\SendFormFactory::class,
            Model\MessagesTable::class => Model\Factory\MessagesTableFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [
            //*** define a resource "messages" which points to 'PrivateMessages\Controller\IndexController',
            'messages' => 'PrivateMessages\Controller\IndexController',
            //*** NAVIGATION LAB: define a private message menu item as a resource
            'menu-messages'     => 'menu-messages',
        ],
        'rights' => [
            'user' => [
                //*** for the "messages" resource users are allowed all actions
                'messages' => ['allow' => NULL],
                //*** NAVIGATION LAB: users are allowed to see any messages menu resource item
                'menu-messages'     => ['allow' => NULL],
            ],
        ],
    ],
];
