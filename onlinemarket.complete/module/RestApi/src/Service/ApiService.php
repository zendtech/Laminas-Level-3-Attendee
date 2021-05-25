<?php
namespace RestApi\Service;

use Laminas\Db\Sql\Sql;

class ApiService
{

    use TableTrait;

    public function fetchAll()
    {
        //*** return all listings
        return $this->table->select()->toArray();
    }
    public function fetchById($id)
    {
        //*** define the logic to retrieve listings with or without and ID
        if ($id) {
            //*** if there is an ID, return only that listing
            return $this->table->select(['listings_id' => $id])->current()->getArrayCopy();
        } else {
            //*** if no ID return all listings
            return $this->table->select()->toArray();
        }
    }
}
