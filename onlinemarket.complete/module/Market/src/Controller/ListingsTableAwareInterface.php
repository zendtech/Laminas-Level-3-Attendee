<?php
namespace Market\Controller;

//*** add the appropriate "use" statement
use Model\Table\ListingsTable;

interface ListingsTableAwareInterface
{
    //*** define the method needed to inject the ListingsTable
    public function setListingsTable(ListingsTable $table);
}
