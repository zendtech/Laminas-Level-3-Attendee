<?php
namespace SecurePost;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'view_manager' => [
        'template_map' => [
            'market/post/index' => __DIR__ . '/../view/market/post/index.phtml',
        ],
    ],
];
