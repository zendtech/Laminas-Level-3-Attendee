<?php
namespace CommandLine\Callbacks;

use Events\TableModule\Model\ {EventTable, RegistrationTable};

class Events
{
    protected $eventsTable;
    protected $regTable;
    public function __construct(EventTable $table, RegistrationTable $regTable)
    {
        $this->eventsTable = $table;
        $this->regTable = $regTable;
    }
    public function __invoke($route, $console)
    {
        if ($route->getMatchedParam('help')) {
            return $console->writeLine("Usage: \n  events [--format=(json|raw)] [--all] [--id=:id] [--only_events] [--help]");
        }
        if ($route->getMatchedParam('all')) {
            $events = $this->eventsTable->findAll();
        } elseif ($id = (int) $route->getMatchedParam('id')) {
            $events = [$this->eventsTable->findById($id)];
        } else {
            $events = [];
        }
        if ($events && !$route->getMatchedParam('only_events')) {
            foreach ($events as $key => $item) {
                $events[$key]['registrations'] = $this->regTable->findAllForEvent($item['id']);
            }
        }
        if ($route->getMatchedParam('format') == 'json') {
            $output = json_encode($events, JSON_PRETTY_PRINT);
        } else {
            $output = var_export($events, TRUE);
        }
        return $console->writeLine($output);
    }
}
