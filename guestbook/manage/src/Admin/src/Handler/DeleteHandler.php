<?php
declare(strict_types=1);
namespace Admin\Handler;

use ArrayObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class DeleteHandler extends BaseHandler
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        $id = $request->getAttribute('id') ?? 0;
        $default = new ArrayObject(['id' => 0, 'name' => 'Unknown', 'email' => 'Unknown']);
        $params['entry'] = $this->service->fetchById((int) $id) ?? $default;
        // Render and return a response:
        return new HtmlResponse($this->renderer->render('admin::delete', $params));
    }
}
