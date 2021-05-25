<?php
namespace Logging;

use Laminas\EventManager\Event as ZendEvent;

class Event extends ZendEvent
{
    const EVENT_LOG = 'logging-log-event';
    const EVENT_SOMETHING = 'logging-log-something';
}
