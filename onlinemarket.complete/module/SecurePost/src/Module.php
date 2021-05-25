<?php
/**
 * Solution to DELEGATORS lab
 */
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
				//*** Create a new service which returns a "Zend\Form\Element\Csrf" element
				'secure-post-csrf-element' => function ($container) {
					return new Csrf('csrf');
				},
			],
			'delegators' => [
				//*** Add a "delegators" key which points the form creation to the delegator
				\Market\Form\PostForm::class => [AddsCsrf::class],
			],
		];
	}
}

