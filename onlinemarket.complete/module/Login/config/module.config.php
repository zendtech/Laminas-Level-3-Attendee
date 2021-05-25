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
            //*** SECURITY::AUTHENTICATION LAB: define aggregate as invokable
            Listener\Aggregate::class => InvokableFactory::class,
        ],
        // override in /config/autoload/login.local.php
        'services' => [
            //*** SECURITY::AUTHENTICATION LAB: make sure this directory exists and is writeable!!!
            'login-storage-filename' => __DIR__ . '/../../../data/auth/storage.txt',
            'login-block-cipher-config' => [
                'openssl', ['algo' => 'aes', 'mode' => 'gcm']
            ],
        ],
    ],
    'listeners' => [
        //*** SECURITY::AUTHENTICATION LAB: add aggregate as listener
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
    //*** NAVIGATION LAB: define default navigation
    'navigation' => [
        'default' => [
            'login' => ['label' => 'Login', 'uri' => '/login/login', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-login'],
            'logout' => ['label' => 'Logout', 'uri' => '/login/logout', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-logout']
        ],
    ],
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [
            //*** define these resources:
            'login' => 'Login\Controller\IndexController',
            //*** NAVIGATION LAB: add these resources
            'menu-login-login'  => 'menu-login-login',
            'menu-login-logout' => 'menu-login-logout',
        ],
        'rights' => [
            'guest' => [
                //*** for the "login" resource, allow guests to use the "login" and "register" actions
                'login' => ['allow' => ['index','login','register']],
                //*** NAVIGATION LAB: allow guests to see the "login" menu option
                'menu-login-login' => ['allow' => NULL],
            ],
            'user' => [
                //*** for the "login" resource, allow users to use the "logout"
                'login' => ['allow' => ['logout']],
                //*** NAVIGATION LAB: allow users to see the "logout" menu option
                'menu-login-logout' => ['allow' => NULL],
                'menu-login-login' => ['deny' => NULL],
            ],
        ],
    ],
];
