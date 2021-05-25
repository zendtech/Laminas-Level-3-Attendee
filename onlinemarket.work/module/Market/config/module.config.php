<?php
namespace Market;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'market' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/market',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/post[/]',
                            'defaults' => [
                                'controller' => Controller\PostController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'lookup' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/lookup[/]',
                                    'defaults' => [
                                        'action'     => 'lookup',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'view' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/view',
                            'defaults' => [
                                'controller' => Controller\ViewController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'slash' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/',
                                ],
                            ],
                            'category' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/category[/:category]',
                                    'constraints' => [
                                        'category' => '[A-Za-z0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'index',
                                    ],
                                ],
                            ],
                            'item' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/item[/:itemId]',
                                    'constraints' => [
                                        'itemId' => '[0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'item',
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
        'services' => [
            // defined in config/autoload/global.php
            /*
            'categories' => [],
            'market-expire-days' => [],
            'market-captcha-options' => [],
            */
            'market-categories-menu-config' => [
                ['label' => 'barter'       , 'route' => 'market/view/category', 'params' => ['category' =>  'barter']],
                ['label' => 'beauty'       , 'route' => 'market/view/category', 'params' => ['category' =>  'beauty']],
                ['label' => 'clothing'     , 'route' => 'market/view/category', 'params' => ['category' =>  'clothing']],
                ['label' => 'computer'     , 'route' => 'market/view/category', 'params' => ['category' =>  'computer']],
                ['label' => 'entertainment', 'route' => 'market/view/category', 'params' => ['category' =>  'entertainment']],
                ['label' => 'free'         , 'route' => 'market/view/category', 'params' => ['category' =>  'free']],
                ['label' => 'garden'       , 'route' => 'market/view/category', 'params' => ['category' =>  'garden']],
                ['label' => 'general'      , 'route' => 'market/view/category', 'params' => ['category' =>  'general']],
                ['label' => 'health'       , 'route' => 'market/view/category', 'params' => ['category' =>  'health']],
                ['label' => 'household'    , 'route' => 'market/view/category', 'params' => ['category' =>  'household']],
                ['label' => 'phones'       , 'route' => 'market/view/category', 'params' => ['category' =>  'phones']],
                ['label' => 'property'     , 'route' => 'market/view/category', 'params' => ['category' =>  'property']],
                ['label' => 'sporting'     , 'route' => 'market/view/category', 'params' => ['category' =>  'sporting']],
                ['label' => 'tools'        , 'route' => 'market/view/category', 'params' => ['category' =>  'tools']],
                ['label' => 'transportation','route' => 'market/view/category', 'params' => ['category' => 'transportation']],
                ['label' => 'wanted'       , 'route' => 'market/view/category', 'params' => ['category' =>  'wanted']],
            ],
            'market-upload-config' => [
                'img_size'   => ['maxWidth' => 1000, 'maxHeight' => 1000],
                'file_size'  => ['max' => 2048000],
                'rename'     => ['target' => realpath(__DIR__ . '/../../../public/images'), 'randomize' => TRUE, 'use_upload_extension' => TRUE],
                'img_url'    => '/images',
            ],
        ],
        'factories' => [
            Form\PostForm::class => Form\Factory\PostFormFactory::class,
            Form\PostFilter::class => Form\Factory\PostFilterFactory::class,
            Listener\CacheAggregate::class => Listener\Factory\CacheAggregateFactory::class,
        ],
    ],
    'listeners' => [
        Listener\CacheAggregate::class,
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\ViewController::class => Controller\Factory\ViewControllerFactory::class,
            Controller\PostController::class => Controller\Factory\PostControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'view_helpers' => [
        'factories' => [
            Helper\LeftLinks::class => InvokableFactory::class,
        ],
        'aliases' => [
            'leftLinks' => Helper\LeftLinks::class,
        ],
    ],
    'navigation' => [
        'default' => [
            'market-home'   => ['label' => 'Home', 'order' => -100, 'route' => 'market', 'resource' => 'menu-market-index'],
            'market-post'   => ['label' => 'Post', 'route' => 'market/post', 'resource' => 'menu-market-post'],
            'market-manage' => ['label' => 'Manage', 'uri' => 'http://localhost:9999', 'resource' => 'menu-market-manage'],
        ],
    ],
    'access-control-config' => [
        'resources' => [
            'market-index' => 'Market\Controller\IndexController',
            'market-view' => 'Market\Controller\ViewController',
            'market-post' => 'Market\Controller\PostController',
            'menu-market-index' => 'menu-market-index',
            'menu-market-post'  => 'menu-market-post',
            'menu-market-manage'  => 'menu-market-manage',
        ],
        'rights' => [
            'guest' => [
                'market-index' => ['allow' => NULL],
                'market-view' => ['allow' => NULL],
                'menu-market-index' => ['allow' => NULL],
            ],
            'user' => [
                'market-post' => ['allow' => NULL],
                'menu-market-post' => ['allow' => NULL],
            ],
            'admin' => [
                'menu-market-manage' => ['allow' => NULL],
            ],
        ],
    ],
];
