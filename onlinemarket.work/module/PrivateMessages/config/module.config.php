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
            Hydrator\FormHydrator::class => InvokableFactory::class,
            Hydrator\TableHydrator::class => InvokableFactory::class,
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
    'access-control-config' => [
        'resources' => [
            'messages' => 'PrivateMessages\Controller\IndexController',
            'menu-messages'     => 'menu-messages',
        ],
        'rights' => [
            'user' => [
                'messages' => ['allow' => NULL],
                'menu-messages'     => ['allow' => NULL],
            ],
        ],
    ],
];
