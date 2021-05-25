<?php
namespace MyDoctrine\Controller;

use MyDoctrine\Repository\ {EventRepo, AttendeeRepo, RegistrationRepo};

trait RepoTrait
{
    protected $eventRepo;
    protected $attendeeRepo;
    protected $registrationRepo;

    public function setEventRepo(EventRepo $repo) {
        $this->eventRepo = $repo;
    }
    public function setAttendeeRepo(AttendeeRepo $repo) {
        $this->attendeeRepo = $repo;
    }
    public function setRegistrationRepo(RegistrationRepo $repo) {
        $this->registrationRepo = $repo;
    }
}
