<?php
namespace Market\Form\Factory;

use Market\Form\PostFilter;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PostFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $filter = new PostFilter();
        $filter->setExpireDays($container->get('market-expire-days'));
        $filter->setCategories($container->get('categories'));
        $filter->setUploadConfig($container->get('market-upload-config'));
        $filter->buildFilter();
        return $filter;
    }
}
