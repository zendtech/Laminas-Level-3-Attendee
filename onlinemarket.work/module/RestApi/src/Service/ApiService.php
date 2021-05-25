<?php
namespace RestApi\Service;

use Zend\Db\Sql\Sql;

class ApiService
{

    use TableTrait;

    public function fetchAll()
    {
        return $this->table->select()->toArray();
    }
    public function fetchById($id)
    {
        if ($id) {
            return $this->table->select(['listings_id' => $id])->current()->getArrayCopy();
        } else {
            return $this->table->select()->toArray();
        }
    }
}
