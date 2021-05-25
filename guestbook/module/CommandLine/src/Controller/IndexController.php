<?php
namespace CommandLine\Controller;

use CommandLine\Traits\ {ConsoleTrait, ConsoleRouteTrait};
use Events\TableModule\Model\ {EventTable, RegistrationTable};

class IndexController
{
    use ConsoleTrait;
    use ConsoleRouteTrait;
    protected $eventsTable;
    protected $regTable;
    public function __construct(EventTable $table, RegistrationTable $regTable)
    {
        $this->eventsTable = $table;
        $this->regTable = $regTable;
    }
    public function indexAction()
    {
        return $this->getConsole()->writeLine(__METHOD__);
    }
    public function testAction()
    {
        return $this->getConsole()->writeLine(__METHOD__ . ':' . $this->getRouteMatch()->getMatchedParam('name'));
    }
    public function eventsAction()
    {
        if ($this->getRouteMatch()->getMatchedParam('all')) {
            $events = $this->eventsTable->findAll();
        } elseif ($id = (int) $this->getRouteMatch()->getMatchedParam('id')) {
            $events = [$this->eventsTable->findById($id)];
        } else {
            $events = [];
        }
        if ($events && !$this->getRouteMatch()->getMatchedParam('only_events')) {
            foreach ($events as $key => $item) {
                $events[$key]['registrations'] = $this->regTable->findAllForEvent($item['id']);
            }
        }
        if ($this->getRouteMatch()->getMatchedParam('format') == 'json') {
            $output = json_encode($events, JSON_PRETTY_PRINT);
        } else {
            $output = var_export($events, TRUE);
        }
        return $this->getConsole()->writeLine($output);
    }
}
