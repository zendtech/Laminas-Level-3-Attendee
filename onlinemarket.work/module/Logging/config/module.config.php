<?php
namespace Logging;

return [
    'service_manager' => [
        'services' => [
            'logging-error-log-filename' => __DIR__ . '/../../../data/logs/error.log',
        ],
    ],
    'listeners' => [
		Listener::class,
	],
];
