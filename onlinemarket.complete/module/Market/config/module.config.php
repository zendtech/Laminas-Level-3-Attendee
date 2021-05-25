<?php
namespace Market;

use Market\Plugin\Flash;
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
            //*** NAVIGATION LAB: define categories navigation
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
            //*** FILE UPLOAD LAB: define config for file upload validators and filter
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
            Flash::class => InvokableFactory::class,
            //*** add missing factory for Market\Listener\CacheAggregate
            Listener\CacheAggregate::class => Listener\Factory\CacheAggregateFactory::class,
        ],
    ],
    'listeners' => [
        //*** add entries to represent listeners defined as aggregates
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
    //*** NAVIGATION LAB: define default navigation
    'navigation' => [
        'default' => [
            'market-home' => ['label' => 'Home', 'order' => -100, 'route' => 'market', 'resource' => 'menu-market-index'],
            'market-post' => ['label' => 'Post', 'route' => 'market/post', 'resource' => 'menu-market-post'],
        ],
    ],
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [

            'market-index' => 'Market\Controller\IndexController',
            //*** define a resource "market-view" which points to 'Market\Controller\ViewController',
            //*** define a resource "market-post" which points to 'Market\Controller\PostController',
            'market-view' => 'Market\Controller\ViewController',
            'market-post' => 'Market\Controller\PostController',

            //*** NAVIGATION LAB: define a market menu item as resources
            'menu-market-index' => 'menu-market-index',
            'menu-market-post'  => 'menu-market-post',
        ],
        'rights' => [
            'guest' => [
                'market-index' => ['allow' => NULL],
                //*** for the "market-view" resource guests are allowed all actions
                'market-view' => ['allow' => NULL],

                //*** NAVIGATION LAB: guests are allowed to see market index and market view menu items
                'menu-market-index' => ['allow' => NULL],
            ],
            'user' => [
                //*** for the "market-post" resource users are allowed all actions
                'market-post' => ['allow' => NULL],
                //*** NAVIGATION LAB: users are allowed to see the market post menu item
                'menu-market-post' => ['allow' => NULL],
            ],
        ],
    ],
];
