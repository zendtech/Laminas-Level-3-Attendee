<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getEventManager();
        $em->addIdentifiers(['IDENTIFIER_DB']);
        $em->trigger('EVENT_DB_MOD', $this,
            ['message' => 'Whatever!!!']);
        return new ViewModel();
    }
    public function exceptionAction()
    {
        //*** LOGGER LAB: an exception will be thrown because there is no corresponding view template
        return new ViewModel();
    }
}
