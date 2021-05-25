<?php
namespace Login;

use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;

use Login\Model\UsersTable;
use Login\Auth\CustomStorage;
use Login\Security\Password;

//*** add required "use" statements
use Zend\Crypt\Password\Bcrypt;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;


class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'services' => [
                //*** define callback which performs BCRYPT password verification
                'login-auth-callback' => function ($hash, $password) {
                    return Password::verify($password, $hash);
                },
            ],
            'factories' => [
                'login-db-adapter' => function ($container) {
                    return new Adapter($container->get('model-primary-adapter-config'));
                },
                //*** define an authentication adapter
                'login-auth-adapter' => function ($container) {
                    //*** add these arguments: auth adapter, tablename, identity col, password col and callback
                    return new CallbackCheckAdapter(
                        $container->get('login-db-adapter'),
                        UsersTable::$tableName,
                        UsersTable::$identityCol,
                        UsersTable::$passwordCol,
                        $container->get('login-auth-callback')
                    );
                },
                'login-auth-storage' => function ($container) {
                    return new CustomStorage($container->get('login-storage-filename'));
                },
                //*** define an authentication adapter
                'login-auth-service' => function ($container) {
                    return new AuthenticationService(
                        //*** need storage and auth adapter as arguments
                        $container->get('login-auth-storage'),
                        $container->get('login-auth-adapter'));
                },
            ],
        ];
    }
}
