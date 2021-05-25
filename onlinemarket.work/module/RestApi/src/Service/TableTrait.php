<?php
namespace RestApi\Service;

use Model\Table\ListingsTable;

trait TableTrait
{
    protected $table;
    public function getTable()
    {
        return $this->table;
    }
    public function setTable(ListingsTable $table)
    {
        $this->table = $table;
    }
}
