<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Laminas\ZendFrameworkBridge',
    'Laminas\Paginator',
    'Laminas\Session',
    'Laminas\I18n',
    'Laminas\Form',
    'Laminas\Hydrator',
    'Laminas\InputFilter',
    'Laminas\Filter',
    'Laminas\Db',
    'Laminas\Cache',
    'Laminas\Log',
    'Laminas\Navigation',
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\Router',
    'Laminas\Validator',
    'Laminas\Mail',
    //'Laminas\DeveloperTools',
    'Application',
    'Market',
    'Model',
    'Events',
    'Registration',
    'SecurePost',
    'Login',
    'RestApi',
    'Cache',
    'AccessControl',
    'PhpSession',
    'Logging',
    'Notification',
    //*** DOCTRINE LAB
    //'DoctrineModule',
    //'DoctrineORMModule',
    //'MyDoctrine',
    //*** ENCRYPTION LAB
    //*** BLOCK CIPHER LAB
    //'Encryption',
    //'PrivateMessages',
    //*** LDAP LAB
    // 'MyLdap',
    //*** OAUTH LAB
    //'AuthOauth',
    //*** TRANSLATION LAB
    // 'Translation',
    //*** PSR7BRIDGE LAB
    // 'DefaultLocale',
    //*** MIDDLEWARE LAB
    // 'Manage',
];
