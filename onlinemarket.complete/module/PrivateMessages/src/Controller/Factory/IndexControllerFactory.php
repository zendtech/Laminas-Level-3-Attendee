<?php
namespace PrivateMessages\Controller\Factory;

use PrivateMessages\Controller\IndexController;
use PrivateMessages\Form\Send as SendForm;
use PrivateMessages\Model\MessagesTable;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new IndexController();
        $controller->setTable($container->get(MessagesTable::class));
        $controller->setSendForm($container->get(SendForm::class));
        // need to inject the identity from the authentication service
        // NOTE: the AccessControl module will prevent unauthorized users from getting here
        $controller->setUser($container->get('login-auth-service')->getIdentity());
        return $controller;
    }
}
