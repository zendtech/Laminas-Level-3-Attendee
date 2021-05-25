<?php
namespace Events;

use Events\Entity\ {Event, Registration, Attendee};
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\ {EventManager, SharedEventManager};
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Db\Adapter\Adapter;
use Laminas\Filter;
use Laminas\Navigation\Service\ConstructedNavigationFactory;
//*** DELEGATING HYDRATOR LAB: add the correct "use" statements
use Laminas\Hydrator\ {HydratorPluginManager, DelegatingHydrator, ClassMethods, ObjectProperty};

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, [$this, 'switchLayout'], 999);
    }
    public function switchLayout(MvcEvent $e)
    {
        $container = $e->getApplication()->getServiceManager();
        $routeMatch = $e->getRouteMatch();
        if ($routeMatch->getParam('module') == __NAMESPACE__) {
            $layout = $e->getViewModel();
            $layout->setTemplate('events/layout/layout');
            $layout->setVariable('authService', $container->get('login-auth-service'));
            $layout->setVariable('acl', $container->get('access-control-market-acl'));
        }
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => InvokableFactory::class,
                Controller\AdminController::class  => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setEventTable($container->get(Model\EventTable::class));
                    return $controller;
                },
                Controller\AjaxController::class  => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setRegTable($container->get(Model\RegistrationTable::class));
                    $controller->setAttendeeTable($container->get(Model\AttendeeTable::class));
                    return $controller;
                },
                Controller\SignupController::class => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setEventTable($container->get(Model\EventTable::class));
                    $controller->setRegTable($container->get(Model\RegistrationTable::class));
                    $controller->setAttendeeTable($container->get(Model\AttendeeTable::class));
                    $controller->setFilter($container->get('events-reg-data-filter'));
                    return $controller;
                },
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'events-db-adapter' => 'model-primary-adapter',
            ],
            'factories' => [
                'events-reg-data-filter' => function ($container) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                           ->attach(new Filter\StripTags());
                    return $filter;
                },
                'events-service-container' => function ($container) {
                    return $container;
                },
                //*** DELEGATING HYDRATOR LAB: define a service which returns an instance of Laminas\Hydrator\DelegatingHydrator
                'events-delegating-hydrator' => function ($container) {
                    //*** DELEGATING HYDRATOR LAB: assign a "ObjectProperty" hydrator to the "Registration" entity and "ClassMethods" to the others
                    $hydroClass = new ClassMethods();
                    $hydroProp  = new ObjectProperty();
                    $manager    = new HydratorPluginManager($container);
                    $manager->setService(Event::class, $hydroClass);
                    $manager->setService(Attendee::class, $hydroClass);
                    $manager->setService(Registration::class, $hydroProp);
                    return new DelegatingHydrator($manager);
                },
                'events-menu' => function ($container) {
                    $factory = new ConstructedNavigationFactory($container->get('events-menu-config'));
                    return $factory->createService($container);
                },
            ],
        ];
    }
}

