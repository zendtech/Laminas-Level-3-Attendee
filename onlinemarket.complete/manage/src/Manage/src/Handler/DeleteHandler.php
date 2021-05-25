<?php
declare(strict_types=1);
namespace Manage\Handler;

use ArrayObject;
use Manage\Domain\ListingsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class DeleteHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    /**
     * @var ListingsService
     */
    private $service;
    public function __construct(TemplateRendererInterface $renderer, ListingsService $service)
    {
        $this->renderer = $renderer;
        $this->service  = $service;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $expected = 0;
        $actual   = 0;
        $listings = [];
        if (strtolower($request->getMethod()) == 'post') {
            $post = $request->getParsedBody();
            error_log(__METHOD__ . ':' . __LINE__ . ':' . var_export($post, TRUE));
            if (isset($post['del']) && isset($post['title'])) {
                foreach ($post['del'] as $index => $id) {
                    if ($this->service->deleteById((int) $id)) {
                        $actual++;
                        $listings[] = new ArrayObject(['title' => $post['title'][$index]]);
                    }
                    $expected++;
                }
            }
        }
        $body = $this->renderer->render(
            'manage::delete',
            ['listings' => $listings, 'expected' => $expected, 'actual' => $actual]);
        return new HtmlResponse($body);
    }
}
