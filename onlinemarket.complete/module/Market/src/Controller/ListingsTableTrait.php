<?php
namespace Market\Controller;

use Model\Table\ListingsTable;

trait ListingsTableTrait
{
    protected $listingsTable;
    public function setListingsTable(ListingsTable $table)
    {
        $this->listingsTable = $table;
    }
}
