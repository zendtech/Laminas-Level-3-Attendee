<?php
declare(strict_types=1);
namespace Admin\Handler;

use Admin\Domain\GuestbookService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

abstract class BaseHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @var GuestbookService
     */
    protected $service;

    public function __construct(TemplateRendererInterface $renderer, GuestbookService $service)
    {
        $this->renderer = $renderer;
        $this->service  = $service;
    }

    abstract public function handle(ServerRequestInterface $request) : ResponseInterface;
}
