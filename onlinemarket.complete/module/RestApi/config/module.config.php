<?php
namespace RestApi;

use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'rest-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api[/][:id]',
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                    ],
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ApiController::class => Controller\Factory\ApiControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ApiService::class => Service\Factory\ApiServiceFactory::class,
        ],
    ],
    'view_manager' => [
        //*** enable the ability to return a JsonModel
        'strategies' => [ 'ViewJsonStrategy' ],
    ],
    'access-control-config' => [
        'resources' => [
            'rest-api-api' => 'RestApi\Controller\ApiController',
        ],
        'rights' => [
            'guest' => [
                'rest-api-api' => ['allow' => NULL],
            ],
        ],
    ],
];
