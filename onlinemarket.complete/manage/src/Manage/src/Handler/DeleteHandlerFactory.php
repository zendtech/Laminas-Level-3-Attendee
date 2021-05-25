<?php
declare(strict_types=1);
namespace Manage\Handler;

use Manage\Domain\ListingsService;
use Psr\Container\ContainerInterface;
use Mezzio\Template\TemplateRendererInterface;

class DeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : DeleteHandler
    {
        $template = $container->get(TemplateRendererInterface::class);
        $service  = $container->get(ListingsService::class);
        return new DeleteHandler($template, $service);
    }
}
