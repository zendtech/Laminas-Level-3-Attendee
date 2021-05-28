<?php
namespace Model;

use Laminas\Hydrator\Reflection;
return [
    'service_manager' => [
        'services' => [
            'model-primary-adapter-config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:hostname=localhost;dbname=zfcourse',
                'username' => 'vagrant',
                'password' => 'vagrant',
            ],
        ],
        'factories' => [
            'model-primary-adapter'   => Adapter\Factory\PrimaryFactory::class,
            'model-listings-table'    => Table\Factory\ListingsTableFactory::class,
            'model-city-codes-table'  => Table\Factory\CityCodesTableFactory::class,
            'model-users-table'       => Table\Factory\UsersTableFactory::class,
        ],
    ],
];
