<?php
namespace Events\Controller;

use Events\Traits\ {EventTableTrait, RegTableTrait, AttendeeTableTrait};
use Events\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ {ViewModel, JsonModel};

class AjaxController extends AbstractActionController
{

    use RegTableTrait;
    use AttendeeTableTrait;

    public function registrationAction()
    {
        $eventId = $this->params('eventId');
        $registrations = $this->regTable->findRegByEventId($eventId);
        $data = [];
        if ($registrations) {
            foreach ($registrations as $item) {
                $subTable = '<table id="attendee_for_' . $item->id . '" class="display">'
                          . '<thead><tr><th>&nbsp;</th></tr></thead>'
                          . '</table>'
                          . '<script>'
                          . '$(document).ready(function() {'
                          . '    $("#attendee_for_' . $item->id . '").'
                          . '        DataTable( {'
                          . '           "ajax": "/events/ajax/attendee/' . $item->id . '",'
                          . '           "bInfo" : false,'
                          . '           "searching" : false,'
                          . '           "paging" : false'
                          . '        } );'
                          . '} );'
                          . '</script>';
                $data[] = [
                    $item->registration_time,
                    $item->first_name,
                    $item->last_name,
                    $subTable];
            }
        }
        return new JsonModel(['data' => $data]);
    }
    public function attendeeAction()
    {
        $regId = $this->params('regId');
        $attendees = $this->attendeeTable->findByRegId($regId);
        $data = [];
        if ($attendees) {
            foreach ($attendees as $item) {
                $data[] = [$item->getNameOnTicket()];
            }
        }
        return new JsonModel(['data' => $data]);
    }
}
