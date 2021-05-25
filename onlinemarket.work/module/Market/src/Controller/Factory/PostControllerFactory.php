<?php
namespace Market\Controller\Factory;

use Market\Controller\PostController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PostControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new PostController();
        $controller->setCityCodesTable($container->get('model-city-codes-table'));
        $controller->setPostForm($container->get('Market\Form\PostForm'));
        $controller->setUploadConfig($container->get('market-upload-config'));
        return $controller;
    }
}
