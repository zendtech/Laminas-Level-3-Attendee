<?php
declare(strict_types=1);
namespace Admin\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class ListHandler extends BaseHandler
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        $params['list'] = $this->service->fetchAll();
        // Render and return a response:
        return new HtmlResponse($this->renderer->render('admin::list', $params));
    }
}
