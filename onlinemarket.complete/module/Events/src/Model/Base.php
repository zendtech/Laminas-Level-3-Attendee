<?php
namespace Events\Model;

use Events\Entity\EventEntityInterface;
use Laminas\EventManager\EventManager;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\HydratingResultSet;
//*** DELEGATING HYDRATOR LAB: add the correct "use" statements
use Laminas\Hydrator\DelegatingHydrator;
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
