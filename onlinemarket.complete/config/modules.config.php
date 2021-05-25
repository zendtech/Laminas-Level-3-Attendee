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
    'Laminas\Session',
    'Laminas\Cache',
    'Laminas\Form',
    'Laminas\InputFilter',
    'Laminas\Filter',
    'Laminas\Paginator',
    'Laminas\Hydrator',
    'Laminas\I18n',
    'Laminas\Db',
    'Laminas\Log',
    //*** EMAIL LAB
    'Laminas\Mail',
    'Notification',
    //*** NAVIGATION LAB
    'Laminas\Navigation',
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\Router',
    'Laminas\Validator',
    'Application',
    'Market',
    //*** DATABASE PERSISTENCE LAB
    'Model',
    'Events',
    'Registration',
    //*** DOCTRINE LAB
    'MyDoctrine',
    //*** DELEGATORS LAB
    'SecurePost',   // disable this and CSRF element disappears from the form
    //*** DOCTRINE ORM LAB
    'DoctrineModule',
    'DoctrineORMModule',
    'MyDoctrine',
    //*** AUTHENTICATION LAB
    'Login',
    //*** ENCRYPTION LAB
    'Encryption',
    'PrivateMessages',
    //*** REST LAB
    'RestApi',
    //*** CACHE LAB
    'Cache',
    //*** ACL Lab
    'AccessControl',
    //*** OAUTH LAB
    'AuthOauth',
    //*** TRANSLATION LAB
    'Translation',
    //*** PSR7BRIDGE LAB
    'DefaultLocale',
    //*** MIDDLEWARE LAB
    'Manage',
    //*** SESSION LAB
    //'PhpSession',
    //*** LOGGER LAB
    'Logging'
];
