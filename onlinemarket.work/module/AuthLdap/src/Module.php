<?php
namespace AuthLdap;

use ArrayObject;
use Throwable;
use InvalidArgumentException;
use Laminas\Mvc\ {MvcEvent, InjectApplicationEventInterface};
use Login\Event\LoginEvent;
use Laminas\Authentication\Adapter\Ldap as LdapAdapter;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $shared = $e->getApplication()->getEventManager()->getSharedManager();
        $shared->attach('*', LoginEvent::EVENT_LOGIN_VIEW_LDAP, [$this, 'injectLinks'], 99);
    }
    public function injectLinks($e)
    {
        $viewModel = $e->getParam('viewModel');
        $viewModel->setVariable('ldapLink', 1);
    }
    public function getModuleDependencies()
    {
        return ['Login'];
    }
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'auth-ldap-adapter' => function ($container) {
                    $config = $container->get('auth-ldap-config');
                    if (!$config) throw new InvalidArgumentException(self::ERROR_NO_CONFIG);
                    $iterator = new ArrayObject($config);
                    // loop through list of LDAP servers until one sticks
                    foreach ($iterator as $obj) {
                        $user = $obj->username ?? '';
                        $pwd  = $obj->password ?? '';
                        try {
                            $adapter = new LdapAdapter($obj->getArrayCopy(), $user, $pwd);
                            if ($adapter) break;
                        } catch (Throwable $t) {
                            error_log(__METHOD__ . ':' . $t->getMessage());
                            $adapter = NULL;
                        }
                    }
                    return $adapter;
                },
            ],
        ];
    }
}
