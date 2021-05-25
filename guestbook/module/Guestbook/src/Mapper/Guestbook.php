<?php
namespace Guestbook\Mapper;

use Guestbook\Model\Guestbook as GuestbookModel;
use Zend\Db\Sql\ {Sql,Expression};
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\ {TableGateway, Feature\EventFeature};
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ObjectProperty;
use Zend\EventManager\EventManager;

class Guestbook
{

    const TABLE_NAME   = 'guestbook';
    const IDENTIFIER   = 'guestbook-mapper';
    const ADD_EVENT    = 'guestbook-mapper-add-event';

    protected $table;
    protected $adapter;
    protected $eventManager;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->eventManager = new EventManager();
        $this->eventManager->addIdentifiers([self::IDENTIFIER]);
        $feature = new EventFeature($this->eventManager);
        $resultSet = new HydratingResultSet(new ObjectProperty, new GuestbookModel);
        $this->table = new TableGateway(self::TABLE_NAME, $adapter, $feature, $resultSet);
    }
    public function findAll()
    {
        return $this->table->select();
    }
    public function getCount()
    {
        $sql = new Sql($this->table->getAdapter());
        $select = $sql->select()->from(self::TABLE_NAME)
                                ->columns(['val' => new Expression('COUNT(id)')]);
        return $this->table->selectWith($select);
    }
    public function add(GuestbookModel $model)
    {
        $hydrator = $this->table->getResultSetPrototype()->getHydrator();
		$data = $hydrator->extract($model);
        unset($data['submit']);
        $data['dateSigned'] = date('Y-m-d H:i:s');
        $result = $this->table->insert($data);
        $this->eventManager->trigger(self::ADD_EVENT, $this, ['model' => $model]);
        return $result;
    }
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
