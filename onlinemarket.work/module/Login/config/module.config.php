<?php
namespace Login;

use PDO;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Form\Login::class => Form\Factory\LoginFormFactory::class,
            Model\UsersTable::class => Model\Factory\UsersTableFactory::class,
            Listener\Aggregate::class => InvokableFactory::class,
        ],
        // override in /config/autoload/login.local.php
        'services' => [
            // make sure this directory exists and is writeable!!!
            'login-storage-filename' => __DIR__ . '/../../../data/auth/storage.txt',
            'login-block-cipher-config' => [
                'openssl', ['algo' => 'aes', 'mode' => 'gcm']
            ],
        ],
    ],
    'listeners' => [
        Listener\Aggregate::class
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            'login' => ['label' => 'Login', 'uri' => '/login/login', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-login'],
            'logout' => ['label' => 'Logout', 'uri' => '/login/logout', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-logout']
        ],
    ],
    'access-control-config' => [
        'resources' => [
            'login' => 'Login\Controller\IndexController',
            'menu-login-login'  => 'menu-login-login',
            'menu-login-logout' => 'menu-login-logout',
        ],
        'rights' => [
            'guest' => [
                'login' => ['allow' => ['index','login','register']],
                'menu-login-login' => ['allow' => NULL],
                'menu-login-logout' => ['deny' => NULL],
            ],
            'user' => [
                'login' => ['allow' => ['logout']],
                'menu-login-logout' => ['allow' => NULL],
                'menu-login-login' => ['deny' => NULL],
            ],
        ],
    ],
];
