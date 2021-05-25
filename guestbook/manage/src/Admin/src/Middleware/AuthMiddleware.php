<?php
declare(strict_types=1);
namespace Admin\Middleware;

use Login\Model\User;   // imported from Guestbook
use Admin\Domain\SessionService;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface.RequestHandlerInterface};
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response\ {HtmlResponse, RedirectResponse};

class AuthMiddleware implements MiddlewareInterface
{
    const AUTH_KEY = 'Zend_Auth';
    /** @var Psr\Container\ContainerInterface */
    protected $container;
    /** @var Admin\Domain\SessionService */
    protected $sessionService;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->sessionService = $container->get(SessionService::class);
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $identity = $this->getIdentityFromStorage();
        if ($identity && $identity->getRole() == 'admin') {
            $response = $handler->handle($request);
        } else {
            $response = new RedirectResponse('http://guestbook/');
        }
        return $response;
    }
    protected function getIdentityFromStorage()
    {
        $authInfo = $this->sessionService->fetchByKey(self::AUTH_KEY);
        $authObj  = $authInfo->value ?? NULL;
        if (is_string($authObj)) $authObj = unserialize($authObj);
        $identity = $authObj->storage ?? NULL;
        return $identity;
    }
}
