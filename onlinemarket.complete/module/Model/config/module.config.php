<?php
namespace Model;

return [
    'service_manager' => [
        'services' => [
            'model-primary-adapter-config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:hostname=localhost;dbname=course',
                'username' => 'vagrant',
                'password' => 'vagrant',
            ],
        ],
        'factories' => [
            'model-primary-adapter'   => Adapter\Factory\PrimaryFactory::class,
            'model-listings-table'    => Table\Factory\ListingsTableFactory::class,
            'model-city-codes-table'  => Table\Factory\CityCodesTableFactory::class,
            'model-users-table'       => Table\Factory\UsersTableFactory::class,
            //*** AGGREGATE HYDRATOR LAB: add an entry for factory to produce aggregate hydrator
            'model-listings-hydrator' => Hydrator\Factory\ListingsHydratorFactory::class,
        ],
    ],
];
