<?php
namespace Events\Model;

use Events\Listener\Event as RegEvent;
use Events\Entity\Attendee;
use Events\Entity\Registration;
use Laminas\Db\Sql\Sql;

// Table Structure:
/*
CREATE TABLE `registration` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `registration_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8
 */

class RegistrationTable extends Base
{
    public static $tableName = 'registration';
    public function findAllForEvent($eventId)
    {
        return $this->findUsingMultiQueries($eventId);
    }
    public function findRegByEventId($eventId)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select();
        $select->from(self::$tableName)->where(['event_id' => $eventId])->order('registration_time DESC');
        return $this->tableGateway->selectWith($select);
    }
    protected function findUsingMultiQueries($eventId)
    {
        $final = [];
        $registrations = $this->findRegByEventId($eventId);
        $attendeeTable = $this->container->get(AttendeeTable::class);
        foreach ($registrations as $reg) {
            $reg->attendees = $attendeeTable->findByRegId($reg->id);
            // the iteration $registrations is "forward-only" which means we need to store it into an array
            $final[] = $reg;
        }
        return $final;
    }
    // produces this SQL statement:
    // SELECT `r`.*, `a`.* FROM `registration` AS `r`
    // INNER JOIN `attendee` AS `a`
    // ON `a`.`registration_id` = `r`.`id` WHERE `r`.`event_id` = '{$eventId}'
    protected function findUsingSqlJoin($eventId)
    {
        // use Laminas\Db\Sql\Sql to do a JOIN
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select();
        $select->from(['r' => RegistrationTable::$tableName])
               ->join(['a' => AttendeeTable::$tableName],
                       'a.registration_id = r.id')
               ->order('r.registration_time DESC, a.registration_id ASC, a.name_on_ticket ASC')
               ->where('r.event_id = :eventId');
        $result = $adapter->query($sql->buildSqlString($select), ['eventId' => $eventId]);
        // loop through results and build Registration entity instances
        $regId = 0;
        $final = [];
        foreach ($result as $item) {
            // when registration ID changes from query results, store Registration object
            if ($regId === 0 || $regId !== $item->registration_id) {
                if ($regId !== 0) $final[$regId] = $regEntity;
                $regEntity = new Registration($item);
                $regId = $item->registration_id;
            }
            // add Attendee instances to "attendees" property
            $regEntity->attendees[] = new Attendee($item);
        }
        $final[$regId] = $regEntity;
    }

    //*** DELEGATING HYDRATOR LAB: use the Laminas\Hydrator\DelegatingHydrator to extract data instead of the one currently used
    public function save(Registration $reg)
    {
        //$hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        $data = $this->hydroDelegator->extract($reg);
        // need to get rid of this property as it's not a column in the "registration" table
        unset($data['attendees']);
        //*** LOG LAB: log if data is saved OK or not
        $this->tableGateway->insert($data);
        //*** EVENTMANAGER LISTENER AGGREGATE LAB: trigger a modification event
        $message = $reg->event_id . ':' . $reg->first_name . ' ' . $reg->last_name;
        $this->eventManager->trigger(RegEvent::MOD_EVENT, $this, ['registration' => $message]);
        return $this->tableGateway->getLastInsertValue();
    }
}
