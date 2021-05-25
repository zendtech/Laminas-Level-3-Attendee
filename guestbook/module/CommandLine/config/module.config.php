<?php
namespace CommandLine;

use Laminas\Mvc\Router\Console\Simple;

return [
    'console' => [
        'router' => [
            'routes' => [
                'app' => [
                    'type' => Simple::class,
                    'route' => 'app --mandatory [--help]',
                    'handler' => Callbacks\App::class,
                ],
                'test' => [
                    'type' => Simple::class,
                    'route' => 'test [--param=:whatever] [--help]',
                    'defaults' => [
                        'color' => 'black',
                        'bgcolor' => 'green',
                    ],
                    'handler' => Callbacks\Test::class,
                ],
                'events' => [
                    'name' => 'events',
                    'type' => Simple::class,
                    'route' => 'events [--format=(json|raw)] [--all] [--id=:id] [--only_events] [--help]',
                    'defaults' => [
                        'format' => 'json',
                    ],
                    'handler' => Callbacks\Events::class,
                ],
            ],
        ],
    ],
    'listeners' => [ Listener\Aggregate::class ],
];
