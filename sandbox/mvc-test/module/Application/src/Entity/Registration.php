<?php
namespace Application\Entity;

use DateTime;
class Registration
{
    protected $id;
    protected $eventId;
    protected $firstName;
    protected $lastName;
    protected $registrationTime;
    public function getRegistrationTime()
    {
        return new DateTime($this->registrationTime);
    }
    public function setRegistrationTime(DateTime $time)
    {
        $this->registrationTime = $time->format('Y-m-d H:i:s');
    }
}
