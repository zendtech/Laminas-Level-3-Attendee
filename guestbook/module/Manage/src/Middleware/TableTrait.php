<?php
namespace Manage\Middleware;

use Zend\Db\TableGateway\TableGateway;
trait TableTrait
{
    protected $table;
    public function setTable(TableGateway $table)
    {
        $this->table = $table;
    }
}
