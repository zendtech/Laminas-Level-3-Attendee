<?php
namespace CommandLine\Traits;

use Zend\Console\Console;
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
