<?php
declare(strict_types=1);
namespace Admin\Handler;

use Admin\Domain\GuestbookService;
use Psr\Container\ContainerInterface;
use Mezzio\Template\TemplateRendererInterface;

class AnyHandlerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        $service = $container->get(GuestbookService::class);
        return new $requestedName($container->get(TemplateRendererInterface::class), $service);
    }
}
