<?php
require __DIR__ . '/../vendor/autoload.php';

define('APP_JSON', 'application/json');
define('APP_HTML', 'text/html');

use Application\ {Log, AppJson, AppHtml, AppTxt};

$middleware = [
    // log
    new Log(),
    // application/json
    new AppJson(),
    // text/html
    new AppHtml(),
    // plain text
    new AppTxt(),
];

return $middleware;
