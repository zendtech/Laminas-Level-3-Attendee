<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Zend\Hydrator\ClassMethods;

class Test
{

    protected $one = 111;
    protected $two = 222;
    protected $three = 333;

    public function hasOne()   { return $this->one;   }
    public function isTwo()    { return $this->two;   }
    public function getThree() { return $this->three; }

}

$test = new Test();
$hydrator = new ClassMethods();
var_dump($hydrator->extract($test));
/** yields:
array(3) {
  ["has_one"]=>int(111)
  ["is_two"]=>int(222)
  ["three"]=>int(333)
}
array(2) {
  ["is_two"]=>int(222)
  ["three"]=>int(333)
}
array(1) {
  ["three"]=>int(333)
}
*/

$hydrator->removeFilter('has');
var_dump($hydrator->extract($test));
/** yields:
array(2) {
  ["is_two"]=>int(222)
  ["three"]=>int(333)
}
array(1) {
  ["three"]=>int(333)
}
*/


$hydrator->removeFilter('is');
var_dump($hydrator->extract($test));
/** yields:
array(1) {
  ["three"]=>int(333)
}
*/

