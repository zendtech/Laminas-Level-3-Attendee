<?php
namespace Events;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

return [
    //*** EVENTMANAGER LISTENER AGGREGATE LAB: attach the listener
    'listeners' => [
        Listener\Aggregate::class,
    ],
    'service_manager' => [
        'factories' => [
            Listener\Aggregate::class => Listener\Factory\AggregateFactory::class,
            //*** DATABASE LAB: define entity classes as invokables
            Entity\Event::class => InvokableFactory::class,
            Entity\Registration::class => InvokableFactory::class,
            Entity\Attendee::class => InvokableFactory::class,
        ],
        'abstract_factories' => [
            //*** ABSTRACT FACTORIES LAB: define an abstract factory which sets the tableGateway property for all table module classes
            ConfigAbstractFactory::class,
        ],
        'services' => [
            //*** NAVIGATION LAB: define navigation for events
            'events-menu-config' => [
                ['label' => 'Events', 'route' => 'events','resource' => 'menu-events', 'pages' => [
                    ['label' => 'Sign Up Form', 'route' => 'events/signup', 'resource' => 'menu-events-signup',
                        // do not need ACL "resource" for pages below this
                        'pages' => [
                            ['label' => 'Event A', 'route' => 'events/signup', 'params' => ['eventId' => 1]],
                            ['label' => 'Event B', 'route' => 'events/signup', 'params' => ['eventId' => 2]],
                        ],
                    ],
                    ['label' => 'Admin Area', 'route' => 'events/admin', 'resource' => 'menu-events-admin',
                        // do not need ACL "resource" for pages below this
                        'pages' => [
                            ['label' => 'Event A', 'route' => 'events/admin', 'params' => ['eventId' => 1]],
                            ['label' => 'Event B', 'route' => 'events/admin', 'params' => ['eventId' => 2]],
                        ],
                    ]],
                ],
            ],
        ],
    ],
    //*** ABSTRACT FACTORIES LAB: define Table Module classes using "ConfigAbstractFactory"
    //*** DELEGATING HYDRATOR LAB: add the DelegatingHydrator as the last argument
    ConfigAbstractFactory::class => [
        Model\EventTable::class => ['events-db-adapter',
                                    Entity\Event::class,
                                    'EventManager',
                                    'events-service-container',
                                    'events-delegating-hydrator'],
        Model\AttendeeTable::class => ['events-db-adapter',
                                       Entity\Attendee::class,
                                       'EventManager',
                                       'events-service-container',
                                       'events-delegating-hydrator'],
        Model\RegistrationTable::class => ['events-db-adapter',
                                           Entity\Registration::class,
                                           'EventManager',
                                           'events-service-container',
                                           'events-delegating-hydrator'],
    ],
    'router' => [
        'routes' => [
            'events' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/events',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                        'module'     => __NAMESPACE__,
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'admin' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/admin[/][:eventId]',
                            'defaults' => [
                                'controller' => Controller\AdminController::class,
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'eventId' => '[0-9]+',
                            ],
                        ],
                    ],
                    'ajax' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/ajax',
                            'defaults' => [
                                'controller' => Controller\AjaxController::class,
                                'action'     => 'registration',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'reg' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/reg/:eventId',
                                    'defaults' => [
                                        'controller' => Controller\AjaxController::class,
                                        'action'     => 'registration',
                                    ],
                                    'constraints' => [
                                        'eventId' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'attendee' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/attendee/:regId',
                                    'defaults' => [
                                        'controller' => Controller\AjaxController::class,
                                        'action'     => 'attendee',
                                    ],
                                    'constraints' => [
                                        'regId' => '[0-9]+',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'signup' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/signup[/][:eventId]',
                            'defaults' => [
                                'controller' => Controller\SignupController::class,
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'eventId' => '[0-9]+',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    //*** NAVIGATION LAB: define default navigation
    'navigation' => [
        'default' => [
            'events' => ['label' => 'Events', 'route' => 'events', 'resource' => 'menu-events']
        ],
    ],
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [
            //*** define a resource 'events-index' which points to 'Events\Controller\IndexController'
            //*** define a resource 'events-admin' which points to 'Events\Controller\AdminController',
            //*** define a resource 'events-sign' which points to 'Events\Controller\SignupController',
            'events-index' => 'Events\Controller\IndexController',
            'events-admin' => 'Events\Controller\AdminController',
            'events-ajax'  => 'Events\Controller\AjaxController',
            'events-sign'  => 'Events\Controller\SignupController',
            //*** NAVIGATION LAB: assign menu items as resources
            'menu-events'        => 'menu-events',
            'menu-events-signup' => 'menu-events-signup',
            'menu-events-admin'  => 'menu-events-admin',
        ],
        'rights' => [
            'guest' => [
                //*** for the 'events-index' resource, guests should be allowed any action
                //*** for the 'events-sign' resource, guests should be allowed any action
                'events-index' => ['allow' => NULL],
                'events-sign'  => ['allow' => NULL],
                //*** NAVIGATION LAB: guest can see the 'menu-events' and 'menu-events-signup' menu items
                'menu-events'        => ['allow' => NULL],
                'menu-events-signup' => ['allow' => NULL],
            ],
            'admin' => [
                //*** for the 'events-admin' resource, admin should be allowed any action
                'events-admin' => ['allow' => NULL],
                'events-ajax'  => ['allow' => NULL],
                //*** NAVIGATION LAB: admin can see the 'menu-admin' item
                'menu-events-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
            ],
        ],
    ],
];
