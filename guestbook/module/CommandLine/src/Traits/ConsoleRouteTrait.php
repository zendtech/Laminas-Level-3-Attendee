<?php
namespace CommandLine\Traits;

use Laminas\Console\Console;
use ZF\Console\Route;

trait ConsoleRouteTrait
{
    protected $routeMatch;
    public function setRouteMatch(Route $route)
    {
        $this->routeMatch = $route;
        return $this;
    }
    /**
     * @return Route $route which was matched
     */
    public function getRouteMatch()
    {
        return $this->routeMatch;
    }
}
