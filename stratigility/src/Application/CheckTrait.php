<?php
namespace Application;
use Psr\Http\Message\ServerRequestInterface;
trait CheckTrait
{
    public function check(ServerRequestInterface $request, string $search)
    {
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
    }
}
