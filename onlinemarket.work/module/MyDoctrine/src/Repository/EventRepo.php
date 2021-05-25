<?php
namespace MyDoctrine\Repository;

use Doctrine\ORM\EntityRepository;

class EventRepo extends EntityRepository
{
    public function findById($eventId)
    {
        return $this->findOneBy(array('id' => $eventId));
    }
    public function save($event)
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
    }
}
