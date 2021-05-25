<?php
namespace Login\Event;

use Zend\EventManager\Event;
class LoginEvent extends Event
{
    const EVENT_LOGIN_VIEW = 'login-view-to-be-rendered';
}
