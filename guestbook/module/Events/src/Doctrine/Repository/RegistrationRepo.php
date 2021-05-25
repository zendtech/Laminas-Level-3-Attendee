<?php
namespace Events\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Events\Doctrine\Entity\Registration;
use Events\Doctrine\Entity\Event;

class RegistrationRepo extends EntityRepository
{

    /**
     * @param Events\Doctrine\Entity\Event $eventEntity
     * @param array $regData
     * @return Events\Doctrine\Entity\Registration $registration
     */
    public function persist(Event $eventEntity, $regData)
    {
        $registration = new Registration();
        $registration->setFirstName($regData['firstName']);
        $registration->setLastName($regData['lastName']);
        $registration->setRegistrationTime(new \DateTime('now'));
        $registration->setEvent($eventEntity);
        return $this->update($registration);
    }
    public function update($registration)
    {
        $em = $this->getEntityManager();
        $em->persist($registration);
        $em->flush();
        return $registration;
    }
}
