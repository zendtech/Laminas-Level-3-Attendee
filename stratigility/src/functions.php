<?php
require __DIR__ . '/../vendor/autoload.php';

define('APP_JSON', 'application/json');
define('APP_HTML', 'text/html');

use Laminas\Diactoros\ResponseFactory;

// NOTE: these are *functions* that provide convenient wrappers:
//       "middleware()" produces middleware from anonymous functions
//       "path()" adds routing and requires that you call "middleware()" as 2nd argument
use function Laminas\Stratigility\middleware;
use function Laminas\Stratigility\path;

// checks "Accept" header
$check = function($request, $search) {
    $headers = $request->getHeaders();
    $accept  = $headers['accept'] ?? '';
    if (!$accept) {
        $result = FALSE;
    } elseif (strpos(implode(' ', $accept), $search) === FALSE) {
        $result = FALSE;
    } else {
        $result = TRUE;
    }
    return $result;
};

$middleware = [
    // log
    middleware(function ($request, $handler) {
        $headers = $request->getHeaders();
        error_log(__METHOD__ . ':' . var_export($headers, TRUE));
        return $handler->handle($request);
    }),
    // application/json
    middleware(function ($request, $handler) use ($check)  {
        if (!$check($request, APP_JSON))
            return $handler->handle($request);
        $data = $request->getServerParams();
        $response = (new ResponseFactory())->createResponse(200);
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response;
    }),
    // text/html
    middleware(function ($request, $handler) use ($check)  {
        if (!$check($request, APP_HTML))
            return $handler->handle($request);
        $data = $request->getServerParams();
        $out = '<ul>';
        foreach ($data as $key => $value)
            $out .= "<li>$key : " . var_export($value, TRUE) . "</li>\n";
        $out .= '</ul>';
        $response = (new ResponseFactory())->createResponse(200);
        $response->getBody()->write($out);
        return $response;
    }),
    // plain text
    middleware(function ($request, $handler)  use ($check) {
        $out = '';
        $data = $request->getServerParams();
        foreach ($data as $key => $value)
            $out .= "$key : " . var_export($value, TRUE) . "\n";
        $response = (new ResponseFactory())->createResponse(200);
        $response->getBody()->write($out);
        return $response;
    }),
];

return $middleware;
