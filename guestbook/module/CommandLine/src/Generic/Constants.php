<?php
namespace CommandLine\Generic;

class Constants
{
    const CACHE_KEY_CLI = 'command-line-cache-cli';
    const CACHE_KEY_CONFIG = 'command-line-cache-config';
    const DEFAULT_ACTION = 'index';
    const ERROR_ROUTE_NOT_FOUND = 'ERROR: route not found' . PHP_EOL;
    const ERROR_SERVICE_NOT_FOUND = 'ERROR: requested service not found' . PHP_EOL;
    const ERROR_ACTION_NOT_FOUND = 'ERROR: action for controller not available' . PHP_EOL;
}
