<?php
namespace Application\Entity;

class Message
{
    const DATE_FORMAT_OUT = 'l,d M Y H:i:s';
    const DATE_FORMAT_IN  = 'Y-m-d H:i:s';
    public $id;
    public $message;
    public $to_email;
    public $from_email;
    public $date_time;
}
