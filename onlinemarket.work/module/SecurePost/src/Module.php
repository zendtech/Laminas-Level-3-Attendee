<?php
namespace SecurePost;

use Zend\Form\Element\Csrf;
use Interop\Container\ContainerInterface;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'secure-post-csrf-element' => function ($container) {
                    return new Csrf('csrf');
                },
            ],
            'delegators' => [
                \Market\Form\PostForm::class => [AddsCsrf::class],
            ],
        ];
    }
}

