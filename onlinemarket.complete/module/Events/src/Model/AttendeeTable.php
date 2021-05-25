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
    //*** DELEGATING HYDRATOR LAB: use the Laminas\Hydrator\DelegatingHydrator to extract data instead of the one currently used
    public function save(Attendee $attendee)
    {
        //$hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        return $this->tableGateway->insert($this->hydroDelegator->extract($attendee));
    }
}
