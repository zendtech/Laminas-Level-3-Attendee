<?php
namespace RestApi\Service;

//*** define the appropriate "use" statements
use Model\Table\ListingsTable;

trait TableTrait
{
    //*** define a property for the "listings" table
    protected $table;
    //*** define a "get" method for the "listings" table
    public function getTable()
    {
        return $this->table;
    }
    //*** define a "set" method which sets the "listings" table
    public function setTable(ListingsTable $table)
    {
        $this->table = $table;
    }
}
