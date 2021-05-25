<?php
namespace Model\Table;

use DateTime;
use DateInterval;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Predicate\Like;
use Laminas\Db\TableGateway\TableGateway;

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
