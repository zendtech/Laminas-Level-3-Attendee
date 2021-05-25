<?php
namespace CommandLine\Callbacks;

class App
{
    public function __invoke($route, $console)
    {
        if ($route->getMatchedParam('help')) {
            $message = 'Usage: ' . PHP_EOL . '  app --mandatory [--help]';
        } else {
            $message = __CLASS__;
        }
        $console->clear();
        return $console->writeLine(__CLASS__);
    }
}
