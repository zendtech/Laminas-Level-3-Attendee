<?php
namespace Logging;

return [
    //*** LOGGER LAB: define appropriate config for error log filename
    'service_manager' => [
        'services' => [
            'logging-error-log-filename' => __DIR__ . '/../../../data/logs/error.log',
        ],
    ],
    'listeners' => [
		Listener::class,
    ],
];
