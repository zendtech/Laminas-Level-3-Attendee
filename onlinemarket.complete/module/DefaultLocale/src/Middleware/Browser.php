<?php
namespace DefaultLocale\Middleware;

use Locale;
//*** PSR7BRIDGE LAB: add the appropriate "use" statements
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};
class Browser
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
		//*** PSR7BRIDGE LAB: get the Accept-Language header from $request
        $acceptLangHeader = $request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? NULL;
        if (empty($acceptLangHeader)) {
            return FALSE;
        }
        $accepted = [];
        $tempList = explode(',', $acceptLangHeader);
        foreach ($tempList as $item) {
            if (strpos($item, ';')) {
                list($locale, $quality) = explode(';', strip_tags($item));
            } elseif (strpos($item, '-')) {
                list($locale, $region) = explode('-', strip_tags($item));
            } else {
                $locale = $item;
            }
            $locale = trim($locale);
            if ($locale !== 'null') $accepted[] = $locale;
        }
        if ($accepted) Locale::setDefault($accepted[0] ?? $accepted[1] ?? $accepted[2]);
    }
}
