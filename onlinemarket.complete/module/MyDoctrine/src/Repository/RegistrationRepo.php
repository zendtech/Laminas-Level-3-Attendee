<?php
namespace MyDoctrine\Repository;

//*** need "use" statements
use Doctrine\ORM\EntityRepository;
use MyDoctrine\Entity\ {Registration, Event};

class RegistrationRepo extends EntityRepository
{

    /**
     * @param Application\Entity\Event $eventEntity
     * @param array $regData
     * @return Application\Entity\Registration $registration
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
