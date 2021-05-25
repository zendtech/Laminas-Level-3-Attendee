<?php
namespace MyDoctrine\Controller;

use MyDoctrine\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Filter;

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
        //*** DOCTRINE LAB: use the event repository to find all events
        $events = ???
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        //*** DOCTRINE LAB: use the event repository to find an event based on its ID
        $event = ???
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
        //*** DOCTRINE LAB: use the registration repository to save the registration
        //*** DOCTRINE LAB: set the registration into the event entity
        //*** DOCTRINE LAB: use the event repository to update the event
        //*** save all attendees for this registration
        foreach ($formData['ticket'] as $nameOnTicket) {
            //*** DOCTRINE LAB: use the attendee repository to save the attendee info
            //*** DOCTRINE LAB: add the attendee entity to the registration entity
            //*** DOCTRINE LAB: use the registration repository to update the registration
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
