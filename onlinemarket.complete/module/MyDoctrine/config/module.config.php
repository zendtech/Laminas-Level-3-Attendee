<?php
namespace MyDoctrine;

use PDO;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
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
                                'controller' => Controller\AdminController::class,
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
                                'controller' => Controller\SignupController::class,
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'event' => '[0-9]+',
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
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'doctrine_annotation_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `doctrine_annotation_driver` for any entity under namespace `MyDoctrine\Entity`
                    'MyDoctrine\Entity' => 'doctrine_annotation_driver'
                ]
            ],
        ],
        // NOTE: "connection" and "configuration" would normally go into a /config/autoload/*.local.php file
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'driver'         => 'pdo_mysql',
                    'host'           => 'localhost',
                    'dbname'         => 'course',
                    'user'           => 'vagrant',
                    'password'       => 'vagrant',
                    'driver_options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                ],
            ],
        ],
        'configuration' => [
            // Configuration for service `doctrine.configuration.orm_default` service
            'orm_default' => [
                // metadata cache instance to use. The retrieved service name will
                // be `doctrine.cache.$thisSetting`
                'metadata_cache'    => 'array',

                // DQL queries parsing cache instance to use. The retrieved service
                // name will be `doctrine.cache.$thisSetting`
                'query_cache'       => 'array',

                // ResultSet cache to use.  The retrieved service name will be
                // `doctrine.cache.$thisSetting`
                'result_cache'      => 'array',

                // Hydration cache to use.  The retrieved service name will be
                // `doctrine.cache.$thisSetting`
                'hydration_cache'   => 'array',

                // Mapping driver instance to use. Change this only if you don't want
                // to use the default chained driver. The retrieved service name will
                // be `doctrine.driver.$thisSetting`
                'driver'            => 'orm_default',

                // Generate proxies automatically (turn off for production)
                'generate_proxies'  => true,

                // directory where proxies will be stored. By default, this is in
                // the `data` directory of your application
                // make sure this directory exists and is writeable
                'proxy_dir'         => __DIR__ . '/../../../data/DoctrineORMModule/Proxy',

                // namespace for generated proxy classes
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',

                // SQL filters. See http://docs.doctrine-project.org/en/latest/reference/filters.html
                'filters'           => [],

                // Custom DQL functions.
                // You can grab common MySQL ones at https://github.com/beberlei/DoctrineExtensions
                // Further docs at http://docs.doctrine-project.org/en/latest/cookbook/dql-user-defined-functions.html
                'datetime_functions' => [],
                'string_functions' => [],
                'numeric_functions' => [],

                // Second level cache configuration (see doc to learn about configuration)
                'second_level_cache' => [],
            ],
        ],
    ],
    //*** NAVIGATION LAB: define default navigation
    'navigation' => [
        'default' => [
            'doctrine' => ['label' => 'Doctrine', 'route' => 'doctrine', 'resource' => 'menu-doctrine']
        ],
    ],
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [
            //*** define a resource 'doctrine-index' which points to 'MyDoctrine\Controller\IndexController'
            //*** define a resource 'doctrine-admin' which points to 'MyDoctrine\Controller\AdminController',
            //*** define a resource 'doctrine-sign' which points to 'MyDoctrine\Controller\SignupController',
            'doctrine-index' => 'MyDoctrine\Controller\IndexController',
            'doctrine-admin' => 'MyDoctrine\Controller\AdminController',
            'doctrine-sign'  => 'MyDoctrine\Controller\SignupController',
            //*** NAVIGATION LAB: assign menu items as resources
            'menu-doctrine'        => 'menu-doctrine',
        ],
        'rights' => [
            'guest' => [
                //*** for the 'doctrine-index' resource, guests should be allowed any action
                //*** for the 'doctrine-sign' resource, guests should be allowed any action
                'doctrine-index' => ['allow' => NULL],
                'doctrine-sign'  => ['allow' => NULL],
                //*** NAVIGATION LAB: guest can see the 'menu-doctrine' menu item
                'menu-doctrine'        => ['allow' => NULL],
            ],
            'admin' => [
                //*** for the 'doctrine-admin' resource, admin should be allowed any action
                'doctrine-admin' => ['allow' => NULL],
            ],
        ],
    ],
];
