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
            'access-control-market-acl' => Acl\Factory\MarketAclFactory::class,
        ],
    ],
    'access-control-config' => [
        //*** define core roles here:
        'roles' => [
            'guest' => NULL,
            //***   user inherits from guest
            'user' => 'guest',
            //***   admin inherits from user
            'admin' => 'user',
        ],
        //*** resources and rights are assigned in each module.config.php file using this format
        /*
        'resources' => [
            'arbitrary-acl-key' => 'Namespace\Controller\WhateverController',
        ],
        'rights' => [
            'guest' => [
                'arbitrary-acl-key' => ['allow' => ['action1','action2',etc.], 'deny' => ['action1','action2',etc]],
            ],
            'user' => [
                'arbitrary-acl-key' => ['allow' => ['action1','action2',etc.], 'deny' => ['action1','action2',etc]],
            ],
            'admin' => [
                'arbitrary-acl-key' => ['allow' => ['action1','action2',etc.], 'deny' => ['action1','action2',etc]],
            ],
        ],
        */
        'assertions' => [
            'date-time-assert-config' => [
                //*** ACL LAB: experiment with these and make sure it works
                'start' => ['hour' => 6, 'minute' => 0, 'second' => 0],
                'stop'  => ['hour' => 22, 'minute' => 0, 'second' => 0],
            ],
        ],
    ],
];
