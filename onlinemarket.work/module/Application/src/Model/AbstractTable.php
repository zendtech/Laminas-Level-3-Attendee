<?php
namespace Application\Model;

use Laminas\Hydrator\HydratorInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;

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
