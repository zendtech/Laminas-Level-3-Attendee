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
        // Grab "id" param
        $id = $request->getAttribute('id') ?? 0;
        $id = (int) $id;
        $default = new ArrayObject(['id' => 0, 'name' => 'Unknown', 'email' => 'Unknown']);
        $params['entry'] = $this->service->fetchById($id ?? $default);
        if ($params['entry']) {
            // Render and return an html response if entry successfully located
            return new HtmlResponse($this->renderer->render('admin::delete', $params));
        }
        // Render and return a problem response:
        return new HtmlResponse($this->renderer->render('admin::problem', $params));
    }
}
