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
    'Zend\Serializer',
    'Zend\I18n',
    'Zend\Router',
    'Zend\Validator',
    'Zend\Form',
    'Zend\Navigation',
    'Zend\Mvc\Plugin\FlashMessenger',
    'WorkArounds',
    'DoctrineModule',
    'DoctrineORMModule',
    'Cache',
    'Application',
    'Guestbook',
    'Events',
    'Login',
    'PrivateMessages',
    'RestApi',
    'AuthOauth',
    'AccessControl',
    'Translation',
    'DefaultLocale',
    'Manage',
    'CommandLine',
];
