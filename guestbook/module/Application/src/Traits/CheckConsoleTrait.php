<?php
namespace Application\Traits;

use Zend\Console\Request as ConsoleRequest;

trait CheckConsoleTrait
{
    protected function checkIfConsole()
    {
        $request = $this->getRequest();
        return ($request instanceof ConsoleRequest);
    }
}
