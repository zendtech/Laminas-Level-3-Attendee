<?php
namespace Application\Model;

use Zend\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

abstract class AbstractTable
{
    public $tableGateway;
    public function __construct(Adapter $adapter, $model, HydratorInterface $hydrator)
    {
        $this->setTableGateway($adapter, $model, $hydrator);
    }
    public function setTableGateway(Adapter $adapter, $model, HydratorInterface $hydrator)
    {
        $prototype = new HydratingResultSet($hydrator, $model);
        $this->tableGateway = new TableGateway(static::$tableName, $adapter, NULL, $prototype);
    }
}
