<?php
namespace Events\Controller;

use Events\Entity\ {Registration, Attendee};
use Events\Traits\ {EventTableTrait, RegTableTrait, AttendeeTableTrait};
use Events\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Filter;

class SignupController extends AbstractActionController
{
    protected $filter;
    use EventTableTrait;
    use RegTableTrait;
    use AttendeeTableTrait;

    public function indexAction()
    {
        $eventId = (int) $this->params('eventId', FALSE);
        if ($eventId) {
            return $this->eventSignup($eventId);
        }
        $events = $this->eventTable->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        if (!$event = $this->eventTable->findById($eventId)) {
            return $this->redirect()->toRoute('events/signup');
        }
        $vm = new ViewModel(array('event' => $event));
        $vm->setTemplate('events/signup/form.phtml');
        if ($this->request->isPost()) {
            $this->processForm($this->params()->fromPost(), $eventId);
            $vm->setTemplate('events/signup/thanks.phtml');
        }
        return $vm;
    }

    protected function processForm(array $formData, $eventId)
    {
        $formData = $this->sanitizeData($formData);
        if (isset($formData['registration']) && isset($formData['ticket'])) {
            $regId = $this->regTable->save(new Registration($formData['registration']));
            foreach ($formData['ticket'] as $name_on_ticket) {
                $this->attendeeTable->save(new Attendee(['registration_id' => $regId, 'name_on_ticket' => $name_on_ticket]));
            }
            return $regId;
        } else {
            return FALSE;
        }
    }

    protected function sanitizeData(array $data)
    {
        $clean  = array();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $this->filter->filter($subItem);
                }
            } else {
                $clean[$key] = $this->filter->filter($item);
            }
        }
        return $clean;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

}
