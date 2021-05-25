<?php
namespace Model\Table;

use DateTime;
use DateInterval;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\TableGateway\TableGateway;

class CityCodesTable extends TableGateway
{
    const TABLE_NAME = 'world_city_area_codes';
    public function findByCity($city)
    {
        $like = new Like('city', $city);
        $select = (new Sql($this->getAdapter()))->select();        
        $select->from(self::TABLE_NAME)
                ->where($like)
               ->order('city desc');
        return $this->selectWith($select);
    }
}
