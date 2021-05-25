<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;


use Application\Listener\Whatever;
use Laminas\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.2dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

	public function onBootstrap(\Laminas\Mvc\MvcEvent $e) 
	{
		$container = $e->getApplication()->getServiceManager();
        $shared = $e->getApplication()->getEventManager()->getSharedManager();
        $shared->attach(
            'IDENTIFIER_DB', 
            'EVENT_DB_MOD', 
            [$this, 'someListener'], 
            100);
        $shared->attach(
            '*', 
            MvcEvent::EVENT_DISPATCH,
            [$container->get(Whatever::class), 'doThis'], 
            100);
    }
    public function someListener($e) 
    {
        $whoTriggered = get_class($e->getTarget());
        $optMessage   = $e->getParam('message') ?? 'Database Was Modified';
        echo '<br>' . __METHOD__ . ':' . $whoTriggered . ':' . $optMessage;
    }
}
