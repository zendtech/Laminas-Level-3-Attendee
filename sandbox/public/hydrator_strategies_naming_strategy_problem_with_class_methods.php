<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Laminas\Hydrator\ {ClassMethodsHydrator, ReflectionHydrator};

class Test
{
    public $last_name = 'Simpson';
    protected $firstName = 'Homer';
    protected $first_name = 'Marge';
    public function getFirstName()  { return $this->firstName;  }
    public function getfirst_name() { return $this->first_name; }
}

$test = new Test();
$hydrator = new ClassMethodsHydrator();
var_dump($hydrator->extract($test));
// yields
/*
array(1) {
  ["first_name"]=>string(5) "Marge"
}
*/

$hydrator = new ReflectionHydrator();
var_dump($hydrator->extract($test));
// yields:
/*
array(3) {
  ["last_name"]=>string(7) "Simpson"
  ["firstName"]=>string(5) "Homer"
  ["first_name"]=>string(5) "Marge"
}
*/

$hydrator = new ClassMethodsHydrator();
$hydrator->removeNamingStrategy();
var_dump($hydrator->extract($test));
// yields
/*
array(2) {
  ["firstName"]=>string(5) "Homer"
  ["first_name"]=>string(5) "Marge"
}
*/

