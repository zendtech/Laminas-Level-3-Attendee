<?php
namespace Events;

use PDO;
use Events\Doctrine\Factory\SignupDelegatorFactory;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Mvc\Controller\LazyControllerAbstractFactory;
use Zend\ServiceManager\AbstractFactory\{ConfigAbstractFactory, ReflectionBasedAbstractFactory};

//use Zend\Mvc\I18n\Router\TranslatorAwareTreeRouteStack;

return [
    'navigation' => [
        'default' => [
            'events' => ['label' => 'Events', 'route' => 'events', 'resource' => 'menu-events']
        ]
    ],
    'router' => [
        //'router_class' => TranslatorAwareTreeRouteStack::class,
        'routes' => [
            'events' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/events',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'table-module' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/table-module',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'admin' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/admin[/][:event]',
                                    'defaults' => [
                                        'controller' => TableModule\Controller\AdminController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'signup' => [
                                'type'    => Segment::class,
                                'options' => [
                                    // example of translatable route:
                                    //'route'    => '/{signup}[/][:event]',
                                    'route'    => '/signup[/][:event]',
                                    'defaults' => [
                                        'controller' => TableModule\Controller\SignupController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'doctrine' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/doctrine',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'admin' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/admin[/][:event]',
                                    'defaults' => [
                                        'controller' => Doctrine\Controller\AdminController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'signup' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/signup[/][:event]',
                                    'defaults' => [
                                        'controller' => Doctrine\Controller\SignupController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'thanks' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/thanks[/]',
                                    'defaults' => [
                                        'controller' => Doctrine\Controller\SignupController::class,
                                        'action'     => 'thanks',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Doctrine\Entity\Event::class               => InvokableFactory::class,
            Doctrine\Entity\Attendee::class            => InvokableFactory::class,
            Doctrine\Entity\Registration::class        => InvokableFactory::class,
            TableModule\Model\EventTable::class        => ReflectionBasedAbstractFactory::class,
            TableModule\Model\AttendeeTable::class     => ReflectionBasedAbstractFactory::class,
            TableModule\Model\RegistrationTable::class => ReflectionBasedAbstractFactory::class,
        ],
        'services' => [
            'events-menu-config' => [
                'events-table-module' => [
                    'label' => 'Table Module',
                    'route' => 'events',
                    'resource' => 'menu-events-tm',
                    'pages' => [
                        ['label' => 'Sign Up Form', 'route' => 'events/table-module/signup', 'resource' => 'menu-events-tm-signup',
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/signup', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/signup', 'params' => ['event' => 2]],
                            ],
                        ],
                        ['label' => 'Admin Area', 'route' => 'events/table-module/admin', 'resource' => 'menu-events-tm-admin',
                            // do not need ACL "resource" for pages below this
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/admin', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/admin', 'params' => ['event' => 2]],
                            ],
                        ],
                    ],
                ],
                'events-doctrine' => [
                    'label' => 'Doctrine',
                    'route' => 'events',
                    'resource' => 'menu-events-doc',
                    'pages' => [
                        ['label' => 'Sign Up Form', 'route' => 'events/doctrine/signup', 'resource' => 'menu-events-doc-signup',
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/doctrine/signup', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/doctrine/signup', 'params' => ['event' => 2]],
                            ],
                        ],
                        ['label' => 'Admin Area', 'route' => 'events/doctrine/admin', 'resource' => 'menu-events-doc-admin',
                            // do not need ACL "resource" for pages below this
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/doctrine/admin', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/doctrine/admin', 'params' => ['event' => 2]],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'abstract_factories' => [
            LazyControllerAbstractFactory::class,
            ConfigAbstractFactory::class,
        ],
        'factories' => [
            Controller\IndexController::class => LazyControllerAbstractFactory::class,
            TableModule\Controller\IndexController::class  => InvokableFactory::class,
            TableModule\Controller\AdminController::class  => TableModule\Controller\Factory\AdminControllerFactory::class,
            TableModule\Controller\SignupController::class  => TableModule\Controller\Factory\SignupControllerFactory::class,
            Doctrine\Controller\IndexController::class  => InvokablesFactory::class,
        ],
        'delegators' => [
            Doctrine\Controller\SignupController::class => [SignupDelegatorFactory::class],
        ],
    ],
    ConfigAbstractFactory::class => [
            Doctrine\Controller\SignupController::class => [
                Doctrine\Repository\EventRepo::class,
                Doctrine\Repository\AttendeeRepo::class,
                Doctrine\Repository\RegistrationRepo::class,
            ],
            Doctrine\Controller\AdminController::class  => [
                Doctrine\Repository\EventRepo::class,
                Doctrine\Repository\AttendeeRepo::class,
                Doctrine\Repository\RegistrationRepo::class,
            ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'access-control-config' => [
        'resources' => [
            'events-index'    => 'Events\Controller\IndexController',
            'events-tb-index' => 'Events\TableModule\Controller\IndexController',
            'events-tb-admin' => 'Events\TableModule\Controller\AdminController',
            'events-tb-sign'  => 'Events\TableModule\Controller\SignupController',
            'events-doc-index'=> 'Events\Doctrine\Controller\IndexController',
            'events-doc-admin'=> 'Events\Doctrine\Controller\AdminController',
            'events-doc-sign' => 'Events\Doctrine\Controller\SignupController',
            'menu-events'           => 'menu-events',
            'menu-events-tm'        => 'menu-events-tm',
            'menu-events-tm-signup' => 'menu-events-tm-signup',
            'menu-events-tm-admin'  => 'menu-events-tm-admin',
            'menu-events-doc'       => 'menu-events-doc',
            'menu-events-doc-signup'=> 'menu-events-doc-signup',
            'menu-events-doc-admin' => 'menu-events-doc-admin',

        ],
        'rights' => [
            'guest' => [
                'events-index'     => ['allow' => NULL],
                'events-tb-index'  => ['allow' => NULL],
                'events-tb-sign'   => ['allow' => NULL],
                'events-doc-index' => ['allow' => NULL],
                'events-doc-sign'  => ['allow' => NULL],
                'menu-events'           => ['allow' => NULL],
                'menu-events-tm'        => ['allow' => NULL],
                'menu-events-tm-signup' => ['allow' => NULL],
                'menu-events-doc'       => ['allow' => NULL],
                'menu-events-doc-signup'=> ['allow' => NULL],
            ],
            'admin' => [
                'events-tb-admin'  => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                'events-doc-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                'menu-events-tm-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                'menu-events-doc-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
            ],
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'events_annotation_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Doctrine/Entity'],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `application_annotation_driver` for any entity under namespace `Application\Entity`
                    'Events\Doctrine\Entity' => 'events_annotation_driver'
                ]
            ],
        ],
    ],
];
