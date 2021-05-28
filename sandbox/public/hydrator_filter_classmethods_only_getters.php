<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';
use Laminas\Hydrator\ClassMethodsHydrator;

class GetHydrator extends ClassMethodsHydrator
{
    public function __construct()
    {
        parent::__construct();
        $this->removeFilter('is');
        $this->removeFilter('has');
    }
}

class Test
{
    protected $one = 111;
    protected $two = 222;
    protected $three = 333;
    public function hasOne()
    {
        return $this->one;
    }
    public function isTwo()
    {
        return $this->two;
    }
    public function getThree()
    {
        return $this->three;
    }
}

$test = new Test();
$hydrator = new GetHydrator();
var_dump($hydrator->extract($test));
/** yields:
array(1) {
  ["three"]=>int(333)
}
*/

