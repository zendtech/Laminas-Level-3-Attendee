<?php
namespace Registration\Form\Factory;

use Registration\Form\RegForm;
use Registration\Form\RegFilter;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RegFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new RegForm($container->get('registration-form-roles'),
                            $container->get('registration-form-providers'),
                            $container->get('registration-form-locales'),
                            $container->get(RegFilter::class));
        return $form;
    }
}
