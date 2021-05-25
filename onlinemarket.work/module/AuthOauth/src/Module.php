<?php
namespace AuthOauth;

use UnexpectedValueException;
use Zend\Mvc\ {MvcEvent, InjectApplicationEventInterface};
use Zend\Session\Container;
use Login\Event\LoginEvent;

use AuthOauth\Generic\ {User, Hydrator};
use AuthOauth\Factory\AdapterAbstractFactory;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $shared = $e->getApplication()->getEventManager()->getSharedManager();
        $shared->attach('*', LoginEvent::EVENT_LOGIN_VIEW, [$this, 'injectLinks'], 99);
    }
    public function injectLinks($e)
    {
        // we need to do this to activate the "Google" button on the main login screen
        $viewModel = $e->getParam('viewModel');
        $viewModel->setVariable('googleLink', 1);
    }
    public function getModuleDependencies()
    {
        return ['Application','Login'];
    }
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'invokables' => [
                'auth-oauth-user-entity' => User::class,
                'auth-oauth-user-hydrator' => Hydrator::class,
            ],
            'factories' => [
                'auth-oauth-provider-list' => function ($sm) {
                    return array_combine(array_keys($sm->get('auth-oauth-config')),
                                         array_keys($sm->get('auth-oauth-config')));
                },
                'auth-oauth-session-container' => function ($container) {
                    return new Container(__NAMESPACE__);
                },
                //*** OAUTH LAB: assign the google adapter service to AdapterAbstractFactory registered below
                'auth-oauth-adapter-google' => Factory\AdapterAbstractFactory::class,
            ],
            'abstract_factories' => [
                //*** OAUTH LAB: register AdapterAbstractFactory here
                Factory\AdapterAbstractFactory::class,
            ],
        ];
    }
}
