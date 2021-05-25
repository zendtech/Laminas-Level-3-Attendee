<?php
declare(strict_types=1);
namespace Manage\Handler;

use Manage\Domain\ListingsService;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        $template = $container->get(TemplateRendererInterface::class);
        $service  = $container->get(ListingsService::class);
        return new ListHandler($template, $service);
    }
}
