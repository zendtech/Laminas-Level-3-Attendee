<?php
namespace Application\Traits;

use Laminas\Console\Request as ConsoleRequest;

trait CheckConsoleTrait
{
    protected function checkIfConsole()
    {
        $request = $this->getRequest();
        return ($request instanceof ConsoleRequest);
    }
}
