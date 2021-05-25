<?php
namespace MyDoctrine\Controller;

use MyDoctrine\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController implements RepoAwareInterface
{
    use RepoTrait;

    public function indexAction()
    {
        $eventId = $this->params('event');
        if ($eventId) {
            return $this->listRegistrations($eventId);
        }
        $events = $this->eventRepo->findAll();
        $viewModel = new ViewModel(array('events' => $events));
        return $viewModel;
    }

    protected function listRegistrations($eventId)
    {
        $event = $this->eventRepo->findById($eventId);
        $viewModel = new ViewModel(array('event' => $event));
        $viewModel->setTemplate('my-doctrine/admin/list.phtml');
        return $viewModel;
    }
}
