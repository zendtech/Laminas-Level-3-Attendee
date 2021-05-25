<?php
namespace Events\Traits;

use Events\Model\TableGatewayInterface;

trait RegTableTrait
{
    protected $regTable;
    public function setRegTable(TableGatewayInterface $table)
    {
        $this->regTable = $table;
    }
}
