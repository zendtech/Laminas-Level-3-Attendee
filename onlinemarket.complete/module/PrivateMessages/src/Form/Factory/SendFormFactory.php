<?php
namespace PrivateMessages\Form\Factory;

use Laminas\Hydrator\ClassMethods;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

use PrivateMessages\Form\Send as SendForm;

class SendFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new SendForm('send');
        $form->addElements();
        $form->addInputFilter();
        return $form;
    }
}
