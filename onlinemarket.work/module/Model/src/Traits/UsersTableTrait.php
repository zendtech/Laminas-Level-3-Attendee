<?php
namespace Model\Traits;

use Application\Model\AbstractTable;

trait UsersTableTrait
{
    protected $table;
    public function setTable(AbstractTable $table)
    {
        $this->table = $table;
    }
}
