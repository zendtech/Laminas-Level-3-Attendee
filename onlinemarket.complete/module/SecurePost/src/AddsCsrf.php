<?php
/**
 * Solution to DELEGATORS lab
 */
namespace SecurePost;

use Laminas\Form\Element\Csrf;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

class AddsCsrf implements DelegatorFactoryInterface
{
	public function __invoke(ContainerInterface $container,
							  $name,
							  callable $callback,
							  array $options = null)
	{
		$form = $callback();
		$form->add($container->get('secure-post-csrf-element'));
		return $form;
	}
}

