<?php
namespace Guestbook;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'navigation' => [
        'default' => [
            'home' => ['label' => 'Home', 'route' => 'home', 'resource' => 'menu-guestbook-home'],
            'sign' => ['label' => 'Sign', 'uri' => '/guestbook/sign', 'resource' => 'menu-guestbook-sign']
        ]
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\GuestbookController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'guestbook' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/guestbook[/:action]',
                    'defaults' => [
                        'controller' => Controller\GuestbookController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'guestbook-audit-filename' => __DIR__ . '/../../../data/logs/guestbook_audit.log',
            'guestbook-avatar-config' => [
                'img_size'   => ['maxWidth' => 100, 'maxHeight' => 100],
                'file_size'  => ['max' => 204800],
                'rename'     => ['target' => realpath(__DIR__ . '/../../../data/uploads'), 'randomize' => TRUE],
            ],
        ],
        'aliases' => [
            // config is in /config/autoload/db.local.php
            'guestbook-db-config' => 'local-db-config',
        ],
        'factories' => [
            Form\Guestbook::class => Form\Factory\GuestbookFormFactory::class,
            Mapper\Guestbook::class => Mapper\Factory\GuestbookMapperFactory::class,
            Listener\CacheAggregate::class => Listener\Factory\CacheAggregateFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\GuestbookController::class => Controller\Factory\GuestbookControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
        'strategies' => ['ViewJsonStrategy'],
    ],
    'listeners' => [
        Listener\CacheAggregate::class,
    ],
    // adds to the module AccessControl configuration
    'access-control-config' => [
        'resources' => [
            'guestbook'           => 'Guestbook\Controller\GuestbookController',
            'menu-guestbook-home' => 'menu-guestbook-home',
            'menu-guestbook-sign' => 'menu-guestbook-sign',
        ],
        'rights' => [
            'guest' => [
                'guestbook' => ['allow' => NULL], // NULL == any rights
                'menu-guestbook-home' => ['allow' => NULL],
                'menu-guestbook-sign' => ['allow' => NULL],
            ],
        ],
    ],
];
