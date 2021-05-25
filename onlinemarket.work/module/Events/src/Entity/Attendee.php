<?php
namespace Events\Entity;

class Attendee extends Base
{
    protected $registration_id;
    protected $name_on_ticket;
    public function getRegistrationId()
    {
        return $this->registration_id;
    }
    public function setRegistrationId($id)
    {
        $this->registration_id = (int) $id;
        return $this;
    }
    public function getNameOnTicket()
    {
        return $this->name_on_ticket;
    }
    public function setNameOnTicket($name)
    {
        $this->name_on_ticket = $name;
        return $this;
    }
}
