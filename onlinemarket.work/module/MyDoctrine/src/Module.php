<?php
namespace MyDoctrine;

use MyDoctrine\Repository\ {AttendeeRepo, EventRepo, RegistrationRepo};
use MyDoctrine\Controller\RepoAwareInterface;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Db\Adapter\Adapter;
use Laminas\Filter;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => InvokableFactory::class,
                Controller\AdminController::class  => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    //*** DOCTRINE LAB: inject  all 3 repositories into controllers
                    return $controller;
                },
                //*** inject  all 3 repositories into controller
                Controller\SignupController::class => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setRegDataFilter($container->get('my-doctrine-reg-data-filter'));
                    //*** DOCTRINE LAB: inject  all 3 repositories into controllers
                    return $controller;
                },
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'my-doctrine-db-adapter' => 'model-primary-adapter',
            ],
            'factories' => [
                'my-doctrine-reg-data-filter' => function ($sm) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                           ->attach(new Filter\StripTags());
                    return $filter;
                },
                // NOTE: factory for Doctrine entity manager already exists: "doctrine.entitymanager.orm_default"
                //*** DOCTRINE LAB: need to define factories for Doctrine repository classes
                EventRepo::class => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new EventRepo($em, $em->getClassMetadata('MyDoctrine\Entity\Event'));
                },
                RegistrationRepo::class => function ($sm) {
                    ???
                },
                AttendeeRepo::class => function ($sm) {
                    ???
                },
                //*** DOCTRINE LAB: these model classes can be "retired"
                Model\EventTable::class => function ($container, $requestedName) {
                    $table = new $requestedName();
                    $table->setTableGateway($container->get('doctrine-db-adapter'));
                    return $table;
                },
                Model\RegistrationTable::class => function ($container, $requestedName) {
                    $table = new $requestedName();
                    $table->setTableGateway($container->get('doctrine-db-adapter'));
                    return $table;
                },
                Model\AttendeeTable::class => function ($container, $requestedName) {
                    $table = new $requestedName();
                    $table->setTableGateway($container->get('doctrine-db-adapter'));
                    return $table;
                },
            ],
        ];
    }
}

