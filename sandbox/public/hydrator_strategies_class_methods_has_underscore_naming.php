<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Laminas\Hydrator\ClassMethodsHydrator;

class Test
{
    protected $id;
    protected $firstName;
    protected $lastName;
    public function getId()        { return $this->id; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName()  { return $this->lastName; }
    public function setId($id)          { $this->id = $id; }
    public function setFirstName($name) { $this->firstName = $name; }
    public function setLastName($name)  { $this->lastName = $name; }
}

$data = ['id' => 1, 'first_name' => 'Homer', 'last_name' => 'Simpson'];
$hydrator = new ClassMethodsHydrator();
$test = $hydrator->hydrate($data, new Test());

var_dump($test);
/* yields:
object(Test)#13 (3) {
  ["id":protected]=>int(1)
  ["firstName":protected]=>string(5) "Homer"
  ["lastName":protected]=>string(7) "Simpson"
} */

var_dump($hydrator->extract($test));
/* yields:
array(3) {
  ["id"]=>int(1)
  ["first_name"]=>string(5) "Homer"
  ["last_name"]=>string(7) "Simpson"
} */
