<?php
include __DIR__ . '/../mvc-test/vendor/autoload.php';

define('TABLE_NAME', 'users');
use Application\Entity\User;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;
use Zend\Debug\Debug;

$config    = include __DIR__ . '/../config/config.php';
$adapter   = new Adapter($config['db']);
$entity    = new User();
$hydrator  = new ObjectPropertyHydrator();
$prototype = new HydratingResultSet($hydrator, $entity);
$table     = new TableGateway(TABLE_NAME, $adapter, null, $prototype);
$result    = $table->select();
foreach ($result as $user) Debug::dump($user);

// Yields:
/*
object(Application\Entity\User)#50 (9) {
  ["id"] => string(1) "1"
  ["email"] => string(15) "google@zend.com"
  ["username"] => string(5) "OAuth"
  ["password"] => NULL
  ["security_question"] => NULL
  ["security_answer"] => NULL
  ["role"] => string(4) "user"
  ["provider"] => string(6) "google"
  ["locale"] => string(2) "en"
}
etc.
*/
