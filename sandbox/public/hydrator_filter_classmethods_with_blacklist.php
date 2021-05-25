<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';

use Zend\Hydrator\ClassMethods;
use Zend\EventManager\EventManager;
use Zend\Hydrator\Filter\ {MethodMatchFilter, FilterComposite};

class Test
{
    protected $one = 111;
    protected $two = 222;
    protected $three = 333;
    protected $em;

    public function __construct(EventManager $em)
    {
        $this->em = $em;
    }

    public function getOne()          { return $this->one; }
    public function getTwo()          { return $this->two; }
    public function getThree()        { return $this->three; }
    public function getEventManager() { return $this->em; }

}

$test = new Test(new EventManager());
$hydrator = new ClassMethods();
var_dump($hydrator->extract($test));
/** yields:
array(1) {
  ["one"]=>int(111)
  ["two"]=>int(222)
  ["three"]=>int(333)
   ["event_manager"]=>
  object(Zend\EventManager\EventManager)#2 (4) { etc. }
}
*/

$hydrator->addFilter('em',
                     new MethodMatchFilter('getEventManager'),
                     FilterComposite::CONDITION_AND);
var_dump($hydrator->extract($test));
/** yields:
array(1) {
  ["one"]=>int(111)
  ["two"]=>int(222)
  ["three"]=>int(333)
}
*/
