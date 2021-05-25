<?php
namespace Events\Entity;

class Registration extends Base
{
    public $event_id;
    public $first_name;
    public $last_name;
    public $registration_time;
    public $attendees = [];
}
