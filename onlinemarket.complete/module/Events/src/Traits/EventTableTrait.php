<?php
namespace Events\Traits;

use Events\Model\TableGatewayInterface;

trait EventTableTrait
{
    protected $eventTable;
    public function setEventTable(TableGatewayInterface $table)
    {
        $this->eventTable = $table;
    }
}
