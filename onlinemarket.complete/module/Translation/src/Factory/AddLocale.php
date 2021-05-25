<?php
namespace Translation\Factory;

//*** add an appropriate "use" statement for the listener aggregate
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

use Laminas\InputFilter\Input;
use Laminas\Form\Element\Select;
use Laminas\Validator\InArray;

class AddLocale implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $form = $callback();
        $element = new Select('locale');
        $element->setLabel('Locale')
                ->setValueOptions($container->get('translation-supported'));
        $input = new Input('locale');
        $input->getValidatorChain()->attach(new InArray(['haystack' => array_keys($container->get('translation-supported'))]));
        $form->add($element);
        $form->getInputFilter()->add($input);
        return $form;
    }
}
