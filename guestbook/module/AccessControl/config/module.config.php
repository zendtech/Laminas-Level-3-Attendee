<?php
namespace AccessControl;

use AccessControl\Listener\AclListenerAggregate;
return [
    'listeners' => [
        AclListenerAggregate::class,
    ],
    'service_manager' => [
        'factories' => [
            'access-control-datetime-assert' => Assertion\Factory\DateTimeAssertFactory::class,
            'access-control-guestbook-acl' => Acl\Factory\GuestbookAclFactory::class,
        ],
    ],
    'access-control-config' => [
        'roles' => [
            'guest' => NULL,
            'user'  => 'guest',
            'admin' => 'user',
        ],
        // resources and rights are assigned in each module.config.php file
        /*
        'resources' => [],
        'rights' => [
            'guest' => [],
            'user' => [],
            'admin' => [],
        ],
        */
        'assertions' => [
            'date-time-assert-config' => [
                'start' => ['hour' => 9, 'minute' => 0, 'second' => 0],
                'stop'  => ['hour' => 22, 'minute' => 0, 'second' => 0],
            ],
        ],
    ],
];
