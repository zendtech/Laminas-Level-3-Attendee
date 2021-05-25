<?php
declare(strict_types=1);
namespace Manage\Domain;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Psr\Container\ContainerInterface;

class ListingsService
{
    const TABLE_NAME = 'listings';
    /** @var ContainerInterface */
    protected $container;
    /** @var TableGateway */
    protected $table;
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $adapter = new Adapter($container->get('model-primary-adapter-config'));
        $this->table = new TableGateway(self::TABLE_NAME, $adapter);
    }
    /**
     * Returns all listings table entries paginated
     *
     * @param int $limit (lines per page)
     * @param int $offset (lines per page * current page number)
     * @return Zend\Db\ResultSet\ResultSet $result
     */
    public function fetchAllPaginated(int $limit = 20, int $offset = 0)
    {
        $select = (new Sql($this->table->getAdapter()))->select();
        $select->from(self::TABLE_NAME)
               ->limit($limit)
               ->offset($offset);
        return $this->table->selectWith($select);
    }
    /**
     * Deletes listings table entry by id
     *
     * @param int $id
     * @return int $numberRowsAffected
     */
    public function deleteById(int $id)
    {
        return $this->table->delete(['listings_id' => $id]);
    }
}
