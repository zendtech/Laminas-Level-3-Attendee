<?php
namespace Model\Table;

use Model\Entity\User;
use Application\Model\AbstractTable;

class UsersTable extends AbstractTable
{

    public static $tableName = 'users';
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function findById($id)
    {
        return $this->tableGateway->select(['id' => $id])->current();
    }
    public function save(User $user)
    {
        $data = $this->tableGateway->getResultSetPrototype()->getHydrator()->extract($user);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->tableGateway->insert($data);
    }
}
