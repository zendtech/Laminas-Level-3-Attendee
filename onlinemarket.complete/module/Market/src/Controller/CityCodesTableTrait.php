<?php
namespace Market\Controller;

use Model\Table\CityCodesTable;

trait CityCodesTableTrait
{
    protected $cityCodesTable;
    public function setCityCodesTable(CityCodesTable $table)
    {
        $this->cityCodesTable = $table;
    }
}
