<?php
namespace CommandLine\Traits;

use Laminas\Console\Console;
trait ConsoleTrait
{
    protected $console = NULL;
    public function getConsole()
    {
        if (!$this->console) {
            $this->console = Console::getInstance();
        }
        return $this->console;
    }
}
