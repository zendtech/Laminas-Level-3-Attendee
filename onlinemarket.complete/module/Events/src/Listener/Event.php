<?php
namespace Events\Listener;

use Laminas\EventManager\Event as ZendEvent;

class Event extends ZendEvent
{
    const MOD_EVENT = 'events-mod-event';
}
