<?php
namespace Events\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel(['serviceManager' => $this->getEvent()->getApplication()->getServiceManager()]);
        return $viewModel;
    }
}
