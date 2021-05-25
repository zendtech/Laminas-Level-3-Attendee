<?php
declare(strict_types=1);
namespace Events\Entity;

class Event extends Base
{
    protected $name;
    protected $max_attendees;
    protected $date;
    public function getId()
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }
    public function getMaxAttendees()
    {
        return $this->max_attendees;
    }
    public function setMaxAttendees(int $num)
    {
        $this->max_attendees = $num;
        return $this;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setDate(string $date)
    {
        $this->date = $date;
        return $this;
    }
}
