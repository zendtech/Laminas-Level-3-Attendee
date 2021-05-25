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
        //*** FILE UPLOADS LAB: you will need to check the 'photo_filename' field
        //***                   if it does not contain "http://" or "https://" you will
        //***                   need prepend "images/<CATEGORY>" to the uploaded filename.
        //***                   Have a look at the "listings" table to see how it works
        //*** AGGREGATE HYDRATOR LAB: the following 8 lines can be removed as the aggregate hydrator will do all this work
        /*
        $listing->date_expires = $this->getDateExpires($listing->expires);
        [$listing->city, $listing->country] = explode(',', $listing->cityCode);
        unset($listing->expires);
        unset($listing->submit);
        unset($listing->cityCode);
        unset($listing->captcha);
        //*** DELEGATORS LAB: remove 'csrf'
        if (isset($listing->csrf)) unset($listing->csrf);
        */
        //*** AGGREGATE HYDRATOR LAB: these 2 lines can remain as is:
        $data = $this->getResultSetPrototype()->getHydrator()->extract($listing);
        return $this->insert($data);
    }
    //*** AGGREGATE HYDRATOR LAB: create a custom hydrator which does this work and add to the Aggregate Hydrator you create
    /*
    protected function getDateExpires($expires)
    {
        $now = new DateTime();
        $now = ($expires) ? $now->add(new DateInterval('P' . (int) $expires . 'D')) : $now;
        return $now->format('Y-m-d H:i:s');
    }
    */
}
