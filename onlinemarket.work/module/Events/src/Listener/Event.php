<?php
namespace Events\Listener;

use Zend\EventManager\Event as ZendEvent;

class Event extends ZendEvent
{
    const MOD_EVENT = 'events-mod-event';
}
