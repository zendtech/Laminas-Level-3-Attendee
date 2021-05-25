<?php
namespace Market;

use Market\Event\LogEvent;
use Zend\Mvc\MvcEvent;
//*** NAVIGATION LAB: add "use" statement for the ConstructedNavigationFactory
use Zend\Navigation\Service\ConstructedNavigationFactory;
use Market\Controller\ListingsTableAwareInterface;

class Module
{
    //*** SHARED EVENT MANAGER LAB: add a listener to the "log" event which records the title of the item posted
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
                //*** NAVIGATION LAB: define navigation for categories
                'market-categories-menu' => function ($container) {
                    $factory = new ConstructedNavigationFactory($container->get('market-categories-menu-config'));
                    return $factory->createService($container);
                },
            ],
        ];
    }
    //*** SERVICES LAB: Initializers: define an initializer which will inject a ListingsTable instance into controllers
    public function getControllerConfig()
    {
        return [
            'initializers' => [
                'market-inject-listings-table' => function ($container, $controller) {
                    //if ($controller instanceof ListingsTableAwareInterface) {
                    //    $controller->setListingsTable($container->get('model-listings-table'));
                    //}
                    // alternatively:
                    if (method_exists($controller, 'setListingsTable')) {
                        $controller->setListingsTable($container->get('model-listings-table'));
                    }
                },
            ],
        ];
    }
}
