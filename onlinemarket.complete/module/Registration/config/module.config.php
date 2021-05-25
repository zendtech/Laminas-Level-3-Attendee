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
        //*** FORMS LAB: define factories for form and filter classes
        'factories' => [
            Form\RegForm::class => Form\Factory\RegFormFactory::class,
            Form\RegFilter::class => Form\Factory\RegFilterFactory::class,
        ],
        //*** FORMS LAB: define configuration services for roles, providers and locales
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
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [
            //*** define these resources:
            'registration' => 'Registration\Controller\RegController',
            //*** NAVIGATION LAB: add these resources
            'menu-registration' => 'menu-registration',
        ],
        'rights' => [
            'guest' => [
                //*** for the "login" resource, allow guests to use the "login" and "register" actions
                'registration' => ['allow' => ['index']],
                //*** NAVIGATION LAB: allow guests to see the "login" menu option
                'menu-registration' => ['allow' => NULL],
            ],
        ],
    ],
];
