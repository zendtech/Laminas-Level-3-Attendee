<?php
namespace Test;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};

class Open implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $contents = '<!DOCTYPE html><html><head><title>Test</title></head><body>';
        return $delegate->process($request->withParsedBody($contents)->withMethod('POST'), $delegate);
    }
}
