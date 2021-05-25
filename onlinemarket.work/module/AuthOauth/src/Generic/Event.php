<?php
namespace AuthOauth\Generic;
use Laminas\EventManager\Event as ZendEvent;
use Laminas\ServiceManager\ServiceManager;
class Event extends ZendEvent
{
    const EVENT_ADD_OAUTH_USER = 'auth-oauth-add-user';    
    const EVENT_CHANNEL        = 'auth-oauth-channel';
}
