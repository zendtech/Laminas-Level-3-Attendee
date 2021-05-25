<?php
namespace Market\Event;

use Zend\EventManager\Event;

class LogEvent extends Event
{

    const LOG_EVENT = 'log-event';
    const LOG_ID    = 'log-identifier';

}
