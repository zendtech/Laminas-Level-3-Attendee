<?php
namespace SecurePost;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'view_manager' => [
        'template_map' => [
            'market/post/index' => __DIR__ . '/../view/market/post/index.phtml',
        ],
    ],
];
