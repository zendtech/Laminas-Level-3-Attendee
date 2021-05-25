<?php
namespace Events\Doctrine\Controller;

use Laminas\View\Model\ViewModel;

class AdminController extends Base
{

    public function indexAction()
    {
        $eventEntity = FALSE;
        $eventId = (int) $this->params('event');
        if ($eventId) {
            return $this->listRegistrations($eventId);
        } else {
            return $this->listEvents();
        }
    }

    protected function listEvents()
    {
        $viewModel = new ViewModel(
            ['events' => $this->eventRepo->findAll()]);
        $viewModel->setTemplate('events/doctrine/admin/index');
        return $viewModel;
    }

    protected function listRegistrations($eventId)
    {
        $eventEntity = $this->eventRepo->findById($eventId);
        $vm = new ViewModel(array('event' => $eventEntity));
        $vm->setTemplate('events/doctrine/admin/list.phtml');
        return $vm;
    }

}
