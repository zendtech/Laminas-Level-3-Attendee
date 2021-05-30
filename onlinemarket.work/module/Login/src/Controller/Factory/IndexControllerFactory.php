<?php
namespace Login\Controller\Factory;

use Login\Controller\IndexController;
use Login\Form\Login as LoginForm;
use Login\Form\Register as RegForm;
use Login\Model\UsersTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;


class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new IndexController();
        $controller->setTable($container->get(UsersTable::class));
        $controller->setLoginForm($container->get(LoginForm::class));
        $controller->setAuthService($container->get('login-auth-service'));
        //*** LDAP LAB: inject an LDAP auth adapter into the controller (see AuthLdap\Traits\LdapTrait)
        return $controller;
    }
}
