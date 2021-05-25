<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Zend\Hydrator\ObjectProperty;
use Zend\Hydrator\Strategy\ {ExplodeStrategy, DateTimeFormatterStrategy};

class Test
{

    public $one;
    public $two;
}

$hydrator = new ObjectProperty();
$hydrator->addStrategy('one',new ExplodeStrategy());
$hydrator->addStrategy('two',new DateTimeFormatterStrategy('D, j M Y'));

$data = ['one'=>'1,2,3','two'=>'Sat, 1 Sep 2018'];
$test = $hydrator->hydrate($data, new Test());
var_dump($hydrator->extract($test));
// yields:
/*
array(2) {
  ["one"]=>string(5) "1,2,3"
  ["two"]=>string(15) "Sat, 1 Sep 2018"
}
*/
var_dump($test);
// yields:
/*
object(Test)#9 (2) {
  ["one"]=>
  array(3) {
    [0]=>string(1) "1"
    [1]=>string(1) "2"
    [2]=>string(1) "3"
  }
  ["two"]=>
  object(DateTime)#11 (3) {
    ["date"]=>string(26) "2018-09-01 06:49:12.000000"
    ["timezone_type"]=>int(3)
    ["timezone"]=>string(3) "UTC"
  }
}
*/
