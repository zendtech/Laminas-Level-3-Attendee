<?php
namespace Admin\Domain;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;

class SessionService
{
    /**
     * @var Adapter
     */
    protected $adapter;
    /**
     * @var TableGateway
     */
    protected $table;
    /**
     * @var use Interop\Container\ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->adapter = new Adapter($container->get('db-config'));
        $this->table = new TableGateway('session_storage', $this->adapter);
    }
    public function fetchAll()
    {
        return $this->table->select();
    }
    public function fetchByKey($key)
    {
        $result = $this->table->select(['key' => $key]);
        if ($result) {
            $result = $result->current();
        }
        return $result;
    }
}
