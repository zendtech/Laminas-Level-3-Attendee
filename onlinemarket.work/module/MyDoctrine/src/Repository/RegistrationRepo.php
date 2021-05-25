<?php
namespace MyDoctrine\Repository;

//*** DOCTRINE LAB: need Doctrine "use" statements
use MyDoctrine\Entity\ {Registration, Event};

class RegistrationRepo extends EntityRepository
{

    //*** DOCTRINE LAB: define logic to save a Registration entity
    /**
     * @param Application\Entity\Event $eventEntity
     * @param array $regData
     * @return Application\Entity\Registration $registration
     */
    public function persist(Event $eventEntity, $regData)
    {
        ???
    }
}
