<?php
namespace PrivateMessages\Model;
use Application\Model\AbstractModel;
class Message extends AbstractModel
{
    // maps properties to database columns
    protected $mapping = [
        'id' => 'id',
        'toEmail' => 'to_email',
        'fromEmail' => 'from_email',
        'message' => 'message',
        'dateTime' => 'date_time'
    ];
}
