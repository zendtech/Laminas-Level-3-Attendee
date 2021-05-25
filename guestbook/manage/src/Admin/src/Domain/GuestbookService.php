<?php
namespace Admin\Domain;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;

class GuestbookService
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
        $this->table = new TableGateway('guestbook', $this->adapter);
    }
    public function fetchAll()
    {
        return $this->table->select();
    }
    public function fetchById(int $id)
    {
        $result = $this->table->select(['id' => $id]);
        if (!$result) {
            $entry = NULL;
        } else {
            $entry = $result->current();
        }
        return $entry;
    }
    public function deleteById(int $id)
    {
        return $this->table->delete(['id' => $id]);
    }
}
