<?php
namespace Registration\Form\Factory;

use Zend\Hydrator\ObjectProperty;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

use Registration\Form\RegForm;
use Registration\Form\RegFilter;

class RegFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $filter = new RegFilter($container->get('registration-form-roles'),
                                $container->get('registration-form-providers'),
                                $container->get('registration-form-locales'));
        return $filter;
    }
}
