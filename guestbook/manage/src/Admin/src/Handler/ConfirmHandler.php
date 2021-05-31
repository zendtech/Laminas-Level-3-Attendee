<?php
declare(strict_types=1);
namespace Admin\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class ConfirmHandler extends BaseHandler
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        $params  = $request->getQueryParams();
        $id      = $request->getAttribute('id') ?? 0;
        $confirm = $params['confirm'] ?? 0;
        $confirm = (int) $confirm;
        if ($confirm == 1 && $id) {
            if (!$this->service->deleteById((int) $id)) {
                return new HtmlResponse($this->renderer->render('admin::problem', $params));
            }
        }
        // Render and return a response:
        $params['list'] = $this->service->fetchAll();
        return new HtmlResponse($this->renderer->render('admin::list', $params));
    }
}
