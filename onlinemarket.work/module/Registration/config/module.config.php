<?php
namespace Registration;

use Zend\Router\Http\Segment;

return [
    'navigation' => [
        'default' => [
            'registration' => ['label' => 'Join Us', 'uri' => '/registration', 'tag' => __NAMESPACE__, 'resource' => 'menu-registration'],
        ]
    ],
    'router' => [
        'routes' => [
            'registration' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/registration[/]',
                    'defaults' => [
                        'controller' => Controller\RegController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Form\RegForm::class => Form\Factory\RegFormFactory::class,
            Form\RegFilter::class => Form\Factory\RegFilterFactory::class,
        ],
        'services' => [
            'registration-form-roles' => ['guest','user','admin'],
            'registration-form-locales' => ['de','en','es','fr'],
            'registration-form-providers' => ['default','google','facebook','twitter'],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\RegController::class => Controller\Factory\RegControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'access-control-config' => [
        'resources' => [
            //*** define these resources:
            'registration' => 'Registration\Controller\RegController',
            'menu-registration' => 'menu-registration',
        ],
        'rights' => [
            'guest' => [
                'registration' => ['allow' => ['index']],
                'menu-registration' => ['allow' => NULL],
            ],
        ],
    ],
];
