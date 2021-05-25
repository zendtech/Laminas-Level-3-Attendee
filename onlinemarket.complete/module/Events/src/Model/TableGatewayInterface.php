<?php
namespace Events\Model;

use Events\Entity\EventEntityInterface;
use Zend\EventManager\EventManager;
use Zend\Db\Adapter\Adapter;
interface TableGatewayInterface
{
    public function __construct(Adapter $adapter, EventEntityInterface $entity, EventManager $em);
}
