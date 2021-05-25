<?php
namespace AuthOauth;

return [
    'router' => [
        'routes' => [
            'auth-oauth' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/oauth[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Factory\IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'service_manager' => [
        'aliases' => [
            //*** alias the authentication service from the Login module
            'auth-oauth-service' => 'login-auth-service',
        ],
        'services' => [
            'auth-oauth-callback' => '/oauth/callback',
            'auth-oauth-storage-filename' => __DIR__ . '/../../../data/auth/auth-oauth.txt',
            // override this in /config/autoload/auth-oauth.local.php
            'auth-oauth-config' => [
                'google' => [
                    'clientId'     => 'client.id.from.apps.googleusercontent.com',
                    'clientSecret' => 'client.secret.apps.googleusercontent.com',
                    'redirectUri'  => 'http://localhost/oauth/callback',
                ],
            ],
        ],
        'factories' => [
            Generic\User::class => InvokableClassFactory::class,
            Generic\Hydrator::class => InvokableClassFactory::class,
            //*** add an entry for AdapterAbstractFactory
            Factory\AdapterAbstractFactory::class => InvokableClassFactory::class,
        ],
    ],
    'access-control-config' => [
        'resources' => [
            'auth-oauth-index' => 'AuthOauth\Controller\IndexController',
        ],
        'rights' => [
            'guest' => [
                'auth-oauth-index' => ['allow' => NULL],
            ],
        ],
    ],
];
