<?php
/**
 * Local Configuration Override for DEVELOPMENT MODE.
 *
 * This configuration override file is for providing configuration to use while
 * in development mode. Run:
 *
 * <code>
 * $ composer development-enable
 * </code>
 *
 * from the project root to copy this file to development.local.php and enable
 * the settings it contains.
 *
 * You may also create files matching the glob pattern `{,*.}{global,local}-development.php`.
 */

return [
    'view_manager' => ['display_exceptions' => TRUE],
    'service_manager' => [
        'services' => [
            'auth-oauth-config' => [
                'google' => [
                    'clientId'     => 'client.id.from.google',
                    'clientSecret' => 'client.secret.from.google',
                    'redirectUri'  => 'http://localhost/oauth/callback',
                    'hostedDomain' => 'http://localhost/',
                ],
            ],
            'cache-config' => [
                'adapter' => [
                    'name'      => 'filesystem',
                    'options'   => ['ttl' => 3600],
                    'cache_dir' => __DIR__ . '/../../data/cache',
                ],
                'plugins' => [
                    'exception_handler' => ['throw_exceptions' => TRUE],
                ],
            ],
        ],
    ],
];
