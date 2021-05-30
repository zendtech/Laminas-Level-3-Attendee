<?php
namespace Login\Event;

use Laminas\EventManager\Event;
class LoginEvent extends Event
{
    const EVENT_LOGIN_VIEW = 'login-view-to-be-rendered';
    const EVENT_LOGIN_VIEW_LDAP = 'login-view-with-ldap';
}
