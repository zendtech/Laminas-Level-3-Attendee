<?php
namespace DefaultLocale\Middleware;

/**
 * Sets the PHP default locale from HTTP headers
 */
use Locale;
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};
class Browser
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $acceptLangHeader = $request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? NULL;
        if (empty($acceptLangHeader)) {
            return FALSE;
        }
        $accepted = [];
        $tempList = explode(',', $acceptLangHeader);
        foreach ($tempList as $item) {
            if (strpos($item, ';')) {
                list($locale, $quality) = explode(';', strip_tags($item));
            } else {
                $locale = $item;
            }
            $accepted[] = $locale;
        }
        if ($accepted) Locale::setDefault($accepted[0]);
    }
}
