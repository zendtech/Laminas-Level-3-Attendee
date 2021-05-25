<?php
namespace Model\Table;

use DateTime;
use DateInterval;

use Model\Entity\Listing;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManager;

class ListingsTable extends TableGateway
{
    const TABLE_NAME = 'listings';
    public function findByCategory($category)
    {
        return $this->select(['category' => $category]);
    }
    public function findById($id)
    {
        return $this->select(['listings_id' => $id])->current();
    }
    public function findLatest()
    {
        $select = (new Sql($this->getAdapter()))->select();
        $select->from(self::TABLE_NAME)
               ->order('listings_id desc')
               ->limit(1);
        return $this->selectWith($select)->current();
    }
    public function save(Listing $listing)
    {
        //*** AGGREGATE HYDRATOR LAB: create a custom hydrator which does this work and add to the Aggregate Hydrator you create
        //*** AGGREGATE HYDRATOR LAB: the following 8 lines can be removed: the aggregate hydrator will do all this
        $data = $this->getResultSetPrototype()->getHydrator()->extract($listing);
        $data['date_expires'] = $this->getDateExpires($data['expires']);
        [$data['city'], $data['country']] = explode(',', $data['cityCode']);
        unset($data['expires']);
        unset($data['submit']);
        unset($data['cityCode']);
        unset($data['captcha']);
        //*** DELEGATORS LAB: remove 'csrf'
        if (isset($data['csrf'])) unset($data['csrf']);
        return $this->insert($data);
    }
    //*** AGGREGATE HYDRATOR LAB: this method can be removed: the aggregate hydrator will do this work
    protected function getDateExpires($expires)
    {
        $now = new DateTime();
        $now = ($expires) ? $now->add(new DateInterval('P' . (int) $expires . 'D')) : $now;
        return $now->format('Y-m-d H:i:s');
    }
}
