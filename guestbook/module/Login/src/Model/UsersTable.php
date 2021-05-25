<?php
namespace Login\Model;

use Application\Model\ {AbstractTable, AbstractModel};
use Login\Security\Password;
use Laminas\Hydrator\ClassMethods;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;

class UsersTable extends AbstractTable
{

    public static $tableName = 'users';
    public static $identityCol = 'email';
    public static $passwordCol = 'password';
    public function findByEmail($email)
    {
        return $this->tableGateway->select(['email' => $email])->current();
    }
    public function save(AbstractModel $user)
    {
        $password = $user->getPassword();
        $user->setPassword(Password::createHash($password));
        return $this->tableGateway->insert($user->extract());
    }
}
