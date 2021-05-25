<?php
namespace Notification\Event;

use Laminas\EventManager\Event;

class NotificationEvent extends Event
{
    const EVENT_NOTIFICATION = 'notification-event-email-notification';
    public static $success = FALSE;
}
