<?php
namespace Registration;

use Model\Table\UsersTable;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\Adapter\Adapter;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

}
