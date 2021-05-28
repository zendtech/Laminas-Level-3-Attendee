<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';

use Application\Entity\Message;
use Application\Hydrator\DateTimeHydrator;
use Application\Hydrator\BlockCipherHydrator;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\Hydrator\Aggregate\AggregateHydrator;

// init vars
define('TABLE_NAME', 'messages');
$key  = 'AXee4aivHieQuei8Ophao8Ooda7AhbiX';
$algo = 'aes-256-gcm';

// configure hydrators
$hydroObj    = new ObjectPropertyHydrator();
$hydroDate   = new DateTimeHydrator();
$hydroCrypto = new BlockCipherHydrator($key, $algo);

// chain hydrators together
$hydroChain = new AggregateHydrator();
$hydroChain->add($hydroObj);

// TODO: uncomment these one and a time and compare results
//$hydroChain->add($hydroDate);
//$hydroChain->add($hydroCrypto);

// configure database classes
$config    = include __DIR__ . '/../config/config.php';
$adapter   = new Adapter($config['db']);
$entity    = new Message();
$prototype = new HydratingResultSet($hydroChain, $entity);
$table     = new TableGateway(TABLE_NAME, $adapter, null, $prototype);
$result    = $table->select();
foreach ($result as $message) var_dump($message);

// results (with all hydrators added the the chain):
/*
object(Application\Entity\Message)#63 (5) {
  ["id"] => string(2) "20"
  ["message"] => string(16) "Test 111 111 111"
  ["to_email"] => string(14) "daryl@zend.com"
  ["from_email"] => string(13) "doug@zend.com"
  ["date_time"] => object(DateTime)#66 (3) {
    ["date"] => string(26) "2017-09-01 14:03:19.000000"
    ["timezone_type"] => int(3)
    ["timezone"] => string(3) "UTC"
  }
}
*/
// etc.
