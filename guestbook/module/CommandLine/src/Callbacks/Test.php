<?php
namespace CommandLine\Callbacks;

use Laminas\Console\Prompt\Select;

class Test
{
    public function __invoke($route, $console)
    {
        $options = [
            'a' => 'Apple OSX',
            'w' => 'Windows 10',
            'u' => 'Ubuntu Linux',
            'r' => 'Redhat Linux',
            'n' => 'none of the above...',
        ];
        $answer = Select::prompt(
            'Which OS do you prefer?',
            $options,
            false,
            false
        );
        if ($route->getMatchedParam('help')) {
            return $console->writeLine('Usage: ' . PHP_EOL . 'test [--param=:whatever] [--help]');
        } else {
            return $console->write('Parameter: ' . $route->getMatchedParam('param') . PHP_EOL . 'You chose: ' . $options[$answer] . PHP_EOL);
        }
    }
}
