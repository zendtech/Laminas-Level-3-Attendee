<?php
declare(strict_types=1);
namespace Admin;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
/**
 * The configuration provider for the Admin module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories' => [
                Handler\ListHandler::class => Handler\AnyHandlerFactory::class,
                Handler\DeleteHandler::class => Handler\AnyHandlerFactory::class,
                Handler\ConfirmHandler::class => Handler\AnyHandlerFactory::class,
                Middleware\AuthMiddleware::class => Domain\ServiceFactory::class,
                Domain\GuestbookService::class => Domain\ServiceFactory::class,
                Domain\SessionService::class => Domain\ServiceFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'admin'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }
}
