<?php
namespace Events;

use Events\Doctrine\Repository\ {AttendeeRepo, EventRepo, RegistrationRepo};
use Events\Doctrine\Controller\RepoAwareInterface;

use Zend\Filter;
use Zend\Db\Adapter\Adapter;
use Zend\Navigation\Service\ConstructedNavigationFactory;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'events-db-adapter' => function ($container) {
                    return new Adapter($container->get('local-db-config'));
                },
                'events-reg-data-filter' => function ($sm) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                           ->attach(new Filter\StripTags());
                    return $filter;
                },
                // We add this so that the table classes can all use the ReflectionBasedAbstractFactory
                // This factory looks for a service which matches the type hint Zend\Db\Adapter\Adapter
                'Zend\Db\Adapter\Adapter' => function ($container) {
                    return new Adapter($container->get('local-db-config'));
                },
                Doctrine\Repository\EventRepo::class => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new EventRepo($em, $em->getClassMetadata('Events\Doctrine\Entity\Event'));
                },
                Doctrine\Repository\RegistrationRepo::class => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new RegistrationRepo($em, $em->getClassMetadata('Events\Doctrine\Entity\Registration'));
                },
                Doctrine\Repository\AttendeeRepo::class => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new AttendeeRepo($em, $em->getClassMetadata('Events\Doctrine\Entity\Attendee'));
                },
                'events-doctrine-data-filter'   => function ($sm) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                          ->attach(new Filter\StripTags());
                    return $filter;
                },
                'events-menu' => function ($sm) {
                    $factory = new ConstructedNavigationFactory($sm->get('events-menu-config'));
                    return $factory->createService($sm);
                },
            ],
        ];
    }
}
