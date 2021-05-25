<?php
namespace Events\Model;

use Events\Entity\Attendee;

class AttendeeTable extends Base
{
    public static $tableName = 'attendee';
    public function findByRegId($regId)
    {
        return $this->tableGateway->select(['registration_id' => $regId]);
    }
    public function save(Attendee $attendee)
    {
        $hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        return $this->tableGateway->insert($hydrator->extract($attendee));
    }
}
