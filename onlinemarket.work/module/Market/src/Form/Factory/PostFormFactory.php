<?php
namespace Market\Form\Factory;

use Model\Entity\Listing;
use Market\Form\PostForm;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
//*** AGGREGATE HYDRATOR LAB: this is no longer needed
use Laminas\Hydrator\ObjectProperty;

class PostFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new PostForm();
        $form->setExpireDays($container->get('market-expire-days'));
        $form->setCategories($container->get('categories'));
        $form->setCaptchaOptions($container->get('market-captcha-options'));
        $form->buildForm();
        $form->setInputFilter($container->get(\Market\Form\PostFilter::class));
        //*** AGGREGATE HYDRATOR LAB: change this to aggregate hydrator obtained from service container
        $form->setHydrator(new ObjectProperty());
        $form->bind(new Listing());
        return $form;
    }
}
