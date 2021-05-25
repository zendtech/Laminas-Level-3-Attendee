<?php
namespace MyDoctrine\Controller;

use MyDoctrine\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AdminController extends AbstractActionController implements RepoAwareInterface
{
    use RepoTrait;

    public function indexAction()
    {
        $eventId = $this->params('event');
        if ($eventId) {
            return $this->listRegistrations($eventId);
        }
        //*** DOCTRINE LAB: use the event repository to find all events
        $events = ???
        $viewModel = new ViewModel(array('events' => $events));
        return $viewModel;
    }

    protected function listRegistrations($eventId)
    {
        //*** DOCTRINE LAB: use the event repository to find an event based on its ID
        $event = ???
        $viewModel = new ViewModel(array('event' => $event));
        $viewModel->setTemplate('my-doctrine/admin/list.phtml');
        return $viewModel;
    }
}
