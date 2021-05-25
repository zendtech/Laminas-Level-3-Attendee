<?php
namespace Market;

use Market\Event\LogEvent;
use Zend\Mvc\MvcEvent;
use Zend\Navigation\Service\ConstructedNavigationFactory;
use Market\Controller\ListingsTableAwareInterface;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectCategories']);
        $shared = $eventManager->getSharedManager();
        $shared->attach(LogEvent::LOG_ID, LogEvent::LOG_EVENT, [$this, 'onLog']);
    }
    public function onLog($e)
    {
        error_log(get_class($e->getTarget()) . ': MARKET ITEM POSTED : ' . $e->getParam('title'));
    }
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function injectCategories(MvcEvent $e)
    {
        $viewModel = $e->getViewModel();
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel->setVariable('categories', $serviceManager->get('categories'));
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'market-categories-menu' => function ($container) {
                    $factory = new ConstructedNavigationFactory($container->get('market-categories-menu-config'));
                    return $factory->createService($container);
                },
            ],
        ];
    }
    public function getControllerConfig()
    {
        return [
            'initializers' => [
                'market-inject-listings-table' => function ($container, $controller) {
                    if (method_exists($controller, 'setListingsTable')) {
                        $controller->setListingsTable($container->get('model-listings-table'));
                    }
                    // alternatively:
                    /*
                    if ($controller instanceof ListingsTableAwareInterface) {
                        $controller->setListingsTable($container->get('model-listings-table'));
                    }
                    */
                },
            ],
        ];
    }
}
