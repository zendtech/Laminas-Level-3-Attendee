<?php
// copy this file to /config/autoload/auth-ldap.local.php
use Laminas\Ldap\Ldap;
return [
    'service_manager' => [
        'services' => [
            'auth-ldap-config' => [
                'server1' => [
                    'host'              => '10.30.30.33',
                    'username'          => 'CN=admin,DC=company,DC=com',
                    'password'          => 'password',
                    'bindRequiresDn'    => true,
                    'accountDomainName' => 'company.com',
                    'baseDn'            => 'DC=company,DC=com',
                    'accountCanonicalForm' => Ldap::ACCTNAME_FORM_DN,
                ],
            ],
        ],
    ],
];
