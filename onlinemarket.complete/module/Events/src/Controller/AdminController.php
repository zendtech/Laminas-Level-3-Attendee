<?php
namespace Events\Controller;

use Events\Traits\ {EventTableTrait, RegTableTrait, AttendeeTableTrait};
use Events\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ {ViewModel, JsonModel};

class AdminController extends AbstractActionController
{

    use EventTableTrait;

    public function indexAction()
    {
        $eventId = $this->params()->fromRoute('eventId', FALSE);
        if ($eventId) {
            $viewModel = new ViewModel(['eventId' => $eventId]);
            $viewModel->setTemplate('events/admin/ajax.phtml');
        } else {
            $events = $this->eventTable->findAll();
            $viewModel = new ViewModel(['events' => $events]);
        }
        return $viewModel;
    }

}
