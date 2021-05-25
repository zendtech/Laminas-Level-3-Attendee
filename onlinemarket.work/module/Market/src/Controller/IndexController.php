<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController implements ListingsTableAwareInterface
{
    use ListingsTableTrait;
    public function indexAction()
    {
        $item = $this->listingsTable->findLatest();
        return new ViewModel(['item' => $item, 'messages' => $this->flashMessenger()->getMessages()]);
    }
}
