<?php
namespace MyDoctrine\Controller;

use MyDoctrine\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Filter;

//*** implement the RepoAwareInterface
class SignupController extends AbstractActionController implements RepoAwareInterface
{
    //*** use the RepoTrait
    use RepoTrait;
    protected $regDataFilter;
    public function indexAction()
    {
        $eventId = (int) $this->params('event');
        if ($eventId) {
            return $this->eventSignup($eventId);
        }
        //*** find all events
        $events = $this->eventRepo->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        //*** find a specific event
        $event = $this->eventRepo->findById($eventId);
        if (!$event) {
            return $this->notFoundAction();
        }
        $vm = new ViewModel(array('event' => $event));
        if ($this->request->isPost()) {
            $this->processForm($this->params()->fromPost(), $event);
            $vm->setTemplate('my-doctrine/signup/thanks.phtml');
        } else {
            $vm->setTemplate('my-doctrine/signup/form.phtml');
        }
        return $vm;
    }

    protected function processForm(array $formData, $event)
    {
        $formData = $this->sanitizeData($formData);
        //*** save the registration
        $reg = $this->registrationRepo->persist($event, $formData);
        $event->setRegistrations($reg);
        $this->eventRepo->save($event);
        //*** save all attendees for this registration
        foreach ($formData['ticket'] as $nameOnTicket) {
            $attendee = $this->attendeeRepo->persist($reg, $nameOnTicket);
            $reg->setAttendees($attendee);
            $this->registrationRepo->update($reg);
        }
        return true;
    }

    protected function sanitizeData(array $data)
    {
        $clean  = array();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $this->regDataFilter->filter($subItem);
                }
            } else {
                $clean[$key] = $this->regDataFilter->filter($item);
            }
        }
        return $clean;
    }
    public function setRegDataFilter($filter)
    {
        $this->regDataFilter = $filter;
    }
}
