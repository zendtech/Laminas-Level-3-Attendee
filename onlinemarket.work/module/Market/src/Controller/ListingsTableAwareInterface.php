<?php
namespace Market\Controller;

use Model\Table\ListingsTable;

interface ListingsTableAwareInterface
{
    public function setListingsTable(ListingsTable $table);
}
