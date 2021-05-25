<?php
namespace Events\Model;

use Events\Entity\EventEntityInterface;
use Zend\EventManager\EventManager;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
//*** DELEGATING HYDRATOR LAB: add the correct "use" statements
use Zend\Hydrator\DelegatingHydrator;
use Psr\Container\ContainerInterface;

class Base implements TableGatewayInterface
{
    public static $tableName;
    protected $tableGateway;
    protected $eventManager;
    protected $container;
    //*** DELEGATING HYDRATOR LAB: have the base class accept a DelegatingHydrator instance
    protected $hydroDelegator;
    public function __construct(Adapter $adapter,
                                EventEntityInterface $entity,
                                EventManager $em,
                                ContainerInterface $container = NULL,
                                DelegatingHydrator $hydro = NULL)
    {
        $resultSet = new HydratingResultSet($hydro, $entity);
        // sets up TableGateway to produce instances of get_class($entity) when queried
        $this->tableGateway = new TableGateway(static::$tableName, $adapter, NULL, $resultSet);
        $this->eventManager = $em;
        $this->container = $container;
        $this->hydroDelegator = $hydro;
    }
}
