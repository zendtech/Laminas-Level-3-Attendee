<?php
namespace Events\TableModule\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Base
{
    public static $tableName;
    protected $tableGateway;
    public function __construct(Adapter $adapter)
    {
        $this->tableGateway = new TableGateway(static::$tableName, $adapter);
    }
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
