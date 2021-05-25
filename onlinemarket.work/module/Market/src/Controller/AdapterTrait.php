<?php
namespace Market\Controller;

use Laminas\Db\Adapter\Adapter;

trait AdapterTrait
{
    protected $adapter;
    public function setAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
