<?php
namespace Events\Model;

use Events\Entity\EventEntityInterface;
use Laminas\EventManager\EventManager;
use Laminas\Db\Adapter\Adapter;
interface TableGatewayInterface
{
    public function __construct(Adapter $adapter, EventEntityInterface $entity, EventManager $em);
}
