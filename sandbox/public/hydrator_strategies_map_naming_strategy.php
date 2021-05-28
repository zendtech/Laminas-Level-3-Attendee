<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Laminas\Hydrator\Reflection;
use Laminas\Hydrator\NamingStrategy\MapNamingStrategy;

class Test
{
    protected $id;
    protected $firstName;
    protected $lastName;
}

$data = ['id' => 1, 'first_name' => 'Homer', 'last_name' => 'Simpson'];
$hydrator = new Reflection();
$test = $hydrator->hydrate($data, new Test());
var_dump($test);
// yields:
/*
object(Test)#7 (3) {
  ["id":protected]=>int(1)
  ["firstName":protected]=>NULL
  ["lastName":protected]=>NULL
}  */


$mapping = ['id' => 'id', 'first_name' => 'firstName', 'last_name' => 'lastName'];
$strategy = MapNamingStrategy::createFromHydrationMap($mapping);
$hydrator->setNamingStrategy($strategy);
$test = $hydrator->hydrate($data, new Test());
var_dump($test);
// yields:
/*
object(Test)#12 (3) {
  ["id":protected]=>int(1)
  ["firstName":protected]=>string(5) "Homer"
  ["lastName":protected]=>string(7) "Simpson"
}  */

var_dump($hydrator->extract($test));
// yields:
/*
array(3) {
  ["id"]=>int(1)
  ["first_name"]=>string(5) "Homer"
  ["last_name"]=>string(7) "Simpson"
}  */

