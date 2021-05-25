<?php
namespace Events\Doctrine\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Events\Doctrine\Repository\ {EventRepo, AttendeeRepo, RegistrationRepo};

class Base extends AbstractActionController
{
    protected $eventRepo;
    protected $attendeeRepo;
    protected $registrationRepo;

    public function __construct(
        EventRepo $repoEvt,
        AttendeeRepo $repoAtt,
        RegistrationRepo $repoReg)
    {
        $this->eventRepo = $repoEvt;
        $this->attendeeRepo = $repoAtt;
        $this->registrationRepo = $repoReg;
    }

}
