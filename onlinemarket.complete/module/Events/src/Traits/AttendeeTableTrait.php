<?php
namespace Events\Traits;

use Events\Model\TableGatewayInterface;

trait AttendeeTableTrait
{
    protected $attendeeTable;
    public function setAttendeeTable(TableGatewayInterface $table)
    {
        $this->attendeeTable = $table;
    }
}
